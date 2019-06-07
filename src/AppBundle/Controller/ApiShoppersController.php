<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LineasPedido;
use AppBundle\Entity\Tienda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiShoppersController
 * @package AppBundle\Controller
 */
class ApiShoppersController extends Controller
{
    /**
     * Recibe un identificador de shopper y una tienda y retorna respuesta JSON con los productos que debe adquirir
     * @Get("/apishoppers/v1/dispatchPedidos/{shopper}/tiendas/{tienda}")
     * @param $shopper integer el shopper que debe adquirir los productos
     * @param $tienda integer identificador de la tienda
     * @return Response
     */
    public function getDispatchPedidoAction($shopper, $tienda)
    {
        //Comprobamos que el shopper esta autenticado y coincide con el shopper pedido
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        if(intval($shopper) !== $user->getIdShopper()){
            return new JsonResponse(array('code' => '400', 'content'=> 'No puedes ver los productos de otros shopppers'));
        }

        //Obtenemos las lineas de pedido que no tienen asignado un shopper en la tienda concreta
        $manager = $this->getDoctrine()->getManager();
        $lineasPedidoSinShopper = $manager->getRepository(LineasPedido::class)->findBy(array("tienda"=>$tienda, "shopper"=> null), array('tienda' => 'DESC'));

        $respuesta = array();
        foreach ($lineasPedidoSinShopper as $lineaPedidoSinShopper){
            $temp = array();
            $temp["tienda"] = $lineaPedidoSinShopper->getTienda()->getIdTienda();
            $temp["producto"] = $lineaPedidoSinShopper->getProducto()->getIdProducto();
            $temp["nombre"] = $lineaPedidoSinShopper->getProducto()->getNombre();
            $temp["descripcion"] = $lineaPedidoSinShopper->getProducto()->getDescripcion();
            $temp["cantidad"] = $lineaPedidoSinShopper->getUnidades();
            $respuesta[] = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($respuesta, 'json');

        //Devolvemos la respuesta
        return new Response($json, 200);
    }

    /**
     * Tiendas disponibles para comprar
     * @Get("/apishoppers/v1/tiendas")
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
     * Datos de un shopper
     * @Get("/apishoppers/v1/shopper")
     * @return Response
     */
    public function getDatosShopper()
    {

        //Obtenemos el token y verificamos que corresponde a un usuario
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        //Obtenemos cliente y datos del pedido
        $shopper = $token->getUser();

        $respuesta = array();
        $respuesta["idShopper"] = $shopper->getIdShopper();
        $respuesta["nombre"] = $shopper->getNombre();

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($respuesta, 'json');

        //Devolvemos la respuesta
        return new Response($json, 200);
    }
}
