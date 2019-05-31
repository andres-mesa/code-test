<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pedido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\BaseRoute;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Post("/api/v1/pedido")
     * Persistir pedido
     */
    public function postPedidoAction(Request $request)
    {
        //Comprobamos que la petición POST es JSON
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {

            //Recuperamos el pedido
            $pedido = json_decode($request->getContent(), true);

            $idCliente = $pedido["idCliente"];
            $direccionCompleta = $pedido["direccionCompleta"];
            $idFranjaEntrega = $pedido["idFranjaEntrega"];
            $origenPedido =$pedido["origenPedido"];
            $productos = $pedido["productos"];

            $pedido = new Pedido();
            $pedido->setIdcliente($idCliente);
            $pedido->setDireccionentrega($direccionCompleta);
            $pedido->setIdfranjaentrega($idFranjaEntrega);
            $pedido->setOrigen($origenPedido);



            //var_dump($pedido);


            $entityManager = $this->getDoctrine()->getManager();

//            $product->setName('Keyboard');
//            $product->setPrice(19.99);
//            $product->setDescription('Ergonomic and stylish!');
//
//            // tells Doctrine you want to (eventually) save the Product (no queries yet)
//            $entityManager->persist($product);
//
//            // actually executes the queries (i.e. the INSERT query)
//            $entityManager->flush();

            //return new Response('Saved new product with id '.$product->getId());
            //var_dump($data);


            return new JsonResponse(array("status"=> "ok", "mensaje"=>"Pedido Recibido"));
        }
        return new JsonResponse('ERROR');
    }

    /**
     * @Get("/api/v1/dispatchPedido/{}")
     *
     */
    public function dispatchPedidoAction()
    {
        return $this->render('AppBundle:Api:dispatch_pedido.html.twig', array(
            // ...
        ));
    }
}
