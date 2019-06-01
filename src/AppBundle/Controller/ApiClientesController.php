<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiClientesController
 * @package AppBundle\Controller
 */
class ApiClientesController extends Controller
{
    /**
     * @Post("/apiclientes/v1/pedido")
     * Crear pedido
     * @param Request $request
     * @return JsonResponse
     */
    public function postPedidoAction(Request $request)
    {

        //Comprobamos que la petición POST es JSON
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {

            //Recuperamos el pedido
            $pedido = json_decode($request->getContent(), true);
            return new JsonResponse(array("status"=> "ok", "mensaje"=>"Pedido Recibido"));
        }
        return new JsonResponse('ERROR');
    }
}
