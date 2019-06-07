<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Direccion;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\LineasPedido;
use AppBundle\Entity\Tienda;
use AppBundle\Entity\Producto;
use AppBundle\Entity\TiendasProductos;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiClientesController
 * @package AppBundle\Controller
 */
class ApiClientesController extends Controller
{
    /**
     * Crear pedido para un cliente
     * @Post("/apiclientes/v1/pedido")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postPedidoAction(Request $request)
    {
        //Obtenemos el token y verificamos que corresponde a un usuario
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        //Obtenemos cliente y datos del pedido
        $cliente = $token->getUser();
        $datosPedido = json_decode($request->getContent(), true);

        //Creamos el nuevo pedido

        $pedido = new Pedido();
        $manager = $this->getDoctrine()->getManager();


        try {
            $pedido->setTelefono($datosPedido["telefono"]);
            $pedido->setOrigen($datosPedido["origenPedido"]);
            $pedido->setIdFranjaEntrega($datosPedido["idFranjaEntrega"]);
            $pedido->setImporteTotal(0.0);
            $pedido->setCliente($cliente);

            $hoy = new \DateTime('now');
            $pedido->setFechaCompra($hoy);
            $pedido->setFechaEntrega(\DateTime::createFromFormat('Y-m-d', $datosPedido["fechaEntrega"]));

            $nombreCompleto = $pedido->getCliente()->getNombre() . " " .$pedido->getCliente()->getApellido1() . " " .$pedido->getCliente()->getApellido2();
            $pedido->setNombreCompleto($nombreCompleto);

            $email = $pedido->getCliente()->getEmail();
            $pedido->setEmail($email);

            //Una direccion aleatoria de ese cliente
            $direcciones = $this->getDoctrine()->getRepository(Direccion::class)->findBy(array("cliente"=>$pedido->getCliente()->getIdCliente()));
            $unaDireccionAleatoriaAleatorio = array_rand($direcciones, 1);
            $pedido->setDireccion($direcciones[$unaDireccionAleatoriaAleatorio]);

            $direccionEntrega = $pedido->getDireccion()->getCalle() . " " . $pedido->getDireccion()->getLocalidad() . " " . $pedido->getDireccion()->getCodPostal();
            $pedido->setDireccionEntrega($direccionEntrega);

            $manager->persist($pedido);
            $manager->flush();


            //Asignamos las lineas de pedido
            foreach ($datosPedido["productos"] as $productoPedido){

                $tienda = $manager->getRepository(Tienda::class)->find($productoPedido["tienda"]);
                $producto = $manager->getRepository(Producto::class)->find($productoPedido["producto"]);

                $lineaPedido = new LineasPedido();
                $lineaPedido->setPedido($pedido);
                $lineaPedido->setTienda($tienda);
                $lineaPedido->setProducto($producto);
                $lineaPedido->setUnidades($productoPedido["cantidad"]);
                $manager->persist($lineaPedido);
                $manager->flush();
            }

            return new JsonResponse(array("status" => "ok", "mensaje"=>"Pedido realizado"));

        } catch (\Exception $e) {
            $manager->remove($pedido);
            $manager->flush();
            throw $e;
        }
    }


    /**
     * Tiendas disponibles de un cliente
     * @Get("/apiclientes/v1/tiendas")
     * @return Response
     */
    public function getTiendasDisponibles()
    {
        $manager = $this->getDoctrine()->getManager();
        $tiendas =  $manager->getRepository(Tienda::class)->findAll();

        $respuesta = array();
        foreach ($tiendas as $tienda){
            $temp = array();
            $temp["idTienda"] = $tienda->getIdTienda();
            $temp["nombre"] = $tienda->getNombre();
            $respuesta[] = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($respuesta, 'json');

        //Devolvemos la respuesta
        return new Response($json, 200);
    }

    /**
     * Productos disponibles en una tienda
     * @Get("/apiclientes/v1/tiendas/{tienda}/productos")
     * @param $tienda integer identificador de la tienda
     * @return Response
     */
    public function getProductosDisponibles($tienda)
    {
        $manager = $this->getDoctrine()->getManager();
        $productosDisponibles =  $manager->getRepository(TiendasProductos::class)->findBy(array("tienda"=>$tienda));

        $respuesta = array();
        foreach ($productosDisponibles as $productoDisponible){
            $temp = array();
            $temp["idTienda"]       = $productoDisponible->getTienda()->getIdTienda();
            $temp["idProducto"]     = $productoDisponible->getProducto()->getIdProducto();
            $temp["nombreProducto"] = $productoDisponible->getProducto()->getNombre();
            $temp["descripcion"]    = $productoDisponible->getProducto()->getDescripcion();
            $temp["precioProducto"] = $productoDisponible->getProducto()->getPrecio();
            $respuesta[] = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($respuesta, 'json');
        return new Response($json, 200);
    }

    /**
     * Direcciones disponibles de un cliente
     * @Get("/apiclientes/v1/cliente/direcciones")
     * @return Response
     */
    public function getDireccionesDisponibles()
    {
        //Obtenemos el token y verificamos que corresponde a un usuario
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        //Obtenemos cliente y datos del pedido
        $cliente = $token->getUser();
        $direcciones = $cliente->getDirecciones();

        $respuesta = array();
        foreach ($direcciones as $direccionDisponible){
            $temp = array();
            $temp["idDireccion"]    = $direccionDisponible->getIdDireccion();
            $temp["calle"]          = $direccionDisponible->getCalle();
            $temp["codPostal"]      = $direccionDisponible->getCodPostal();
            $temp["localidad"]      = $direccionDisponible->getLocalidad();;
            $respuesta[] = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($respuesta, 'json');
        return new Response($json, 200);
    }
}
