<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiShoppersController
 * @package AppBundle\Controller
 */
class ApiShoppersController extends Controller
{
    /**
     * @Get("/apishoppers/v1/dispatchPedidos")
     */
    public function dispatchPedidoAction()
    {
        return new JsonResponse(array("status"=> "ok", "mensaje"=>"Lista de la compra"));
    }
}
