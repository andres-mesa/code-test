<?php
namespace AppBundle\Controller;

use AppBundle\Entity\OrderLines;
use AppBundle\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShoppersApiController
 * @package AppBundle\Controller
 */
class ShoppersApiController extends Controller
{
    /**
     * Get shopper id and shop id, returns json response with all the products the shopper will have to buy in the current shop
     * @Get("/shoppersapi/v1/dispatchorders/{shopper}/shops/{shop}")
     * @param $shopper integer the shopper that is requesting the product list
     * @param $shop integer the shop the shopper is interested in
     * @return Response
     */
    public function getDispatchOrderAction($shopper, $shop)
    {
        //Get the shopper token and check that the shopper has correct credentials
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'User not found'));
        }

        if(intval($shopper) !== $user->getId()){
            return new JsonResponse(array('code' => '400', 'content'=> 'You cannot see other shoppers dispatches'));
        }

        //Get the order lines not assigned to other shopper
        $manager = $this->getDoctrine()->getManager();
        $orderLinesNotAssigned = $manager->getRepository(OrderLines::class)->findBy(array("shop"=>$shop, "shopper"=> null), array('shop' => 'DESC'));


        //Get the array that contains the available products, fill the data and return response
        $response = array();
        foreach ($orderLinesNotAssigned as $orderLineNotAssigned){
            $temp = array();
            $temp["shopId"]         = $orderLineNotAssigned->getShop()->getId();
            $temp["productID"]      = $orderLineNotAssigned->getProduct()->getId();
            $temp["name"]           = $orderLineNotAssigned->getProduct()->getName();
            $temp["description"]    = $orderLineNotAssigned->getProduct()->getDescription();
            $temp["units"]          = $orderLineNotAssigned->getUnits();
            $response[]            = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');
        return new Response($json, 200);
    }

    /**
     * Available shops
     * @Get("/shoppersapi/v1/shops")
     * @return Response
     */
    public function getAvailableShops()
    {
        $manager = $this->getDoctrine()->getManager();
        $shops =  $manager->getRepository(Shop::class)->findAll();

        //Get the available shops and return JSON response
        $response = array();
        foreach ($shops as $shop){
            $temp = array();
            $temp["shopId"]   = $shop->getId();
            $temp["name"]     = $shop->getName();
            $response[]        = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');
        return new Response($json, 200);
    }

    /**
     * Shopper personal information
     * @Get("/shoppersapi/v1/shopper")
     * @return Response
     */
    public function getShopperData()
    {

        //Get security token and check user is logged in
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        $shopper = $token->getUser();

        //Return request with current shopper data
        $response = array();
        $response["shopperId"]  = $shopper->getId();
        $response["name"]       = $shopper->getName();

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');
        return new Response($json, 200);
    }
}
