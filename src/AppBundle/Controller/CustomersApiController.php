<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderLines;
use AppBundle\Entity\Shop;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductsShops;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CustomersApiController
 * @package AppBundle\Controller
 */
class CustomersApiController extends Controller
{
    /**
     * API action to perform a new Order
     * @Post("/customersapi/v1/order")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postOrderAction(Request $request)
    {
        //Get the token in order to check the requester identity
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'User not found'));
        }

        //Get customer data
        $customer = $token->getUser();
        $orderData = json_decode($request->getContent(), true);

        //Create the new order
        $order = new Order();
        $manager = $this->getDoctrine()->getManager();

        try {
            $order->setPhone($orderData["phone"]);
            $order->setOrigin($orderData["origin"]);
            $order->setDeliverySlotId($orderData["deliverySlotId"]);
            $order->setTotal(0.0);
            $order->setCustomer($customer);


            $today = new \DateTime('now');
            $order->setOrderDate($today);
            $order->setDeliveryDate(\DateTime::createFromFormat('Y-m-d', $orderData["deliveryDate"]));

            $fullName = $order->getCustomer()->getName() . " " .$order->getCustomer()->getSurname1() . " " .$order->getCustomer()->getSurname2();
            $order->setFullName($fullName);

            $email = $order->getCustomer()->getEmail();
            $order->setEmail($email);

            //Find the address
            $address = $this->getDoctrine()->getRepository(Address::class)->findOneBy(array("customer"=>$order->getCustomer()->getId()));
            $order->setAddress($address);

            $deliveryAddress = $order->getAddress()->getStreet() . " " . $order->getAddress()->getCity() . " " . $order->getAddress()->getZipCode();
            $order->setDeliveryAddress($deliveryAddress);

            $manager->persist($order);
            $manager->flush();


            //Fill product lines
            foreach ($orderData["products"] as $orderLineItem){

                $shop = $manager->getRepository(Shop::class)->find($orderLineItem["shopId"]);
                $product = $manager->getRepository(Product::class)->find($orderLineItem["productId"]);

                $orderLine = new OrderLines();
                $orderLine->setOrder($order);
                $orderLine->setShop($shop);
                $orderLine->setProduct($product);
                $orderLine->setUnits(intval($orderLineItem["units"]));
                $manager->persist($orderLine);
                $manager->flush();
            }

            return new JsonResponse(array("status" => "ok", "mensaje"=>"Order Ready"));

        } catch (\Exception $e) {
            $manager->remove($order);
            $manager->flush();
            throw $e;
        }
    }


    /**
     * Avariable shops
     * @Get("/customersapi/v1/shops")
     * @return Response
     */
    public function getTiendasDisponibles()
    {
        $manager = $this->getDoctrine()->getManager();
        $shops =  $manager->getRepository(Shop::class)->findAll();

        $response = array();
        foreach ($shops as $shop){
            $temp = array();
            $temp["id"] = $shop->getId();
            $temp["nombre"] = $shop->getName();
            $response[] = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');

        return new Response($json, 200);
    }

    /**
     * Avariable products in given shop
     * @Get("/customersapi/v1/shops/{shop}/products")
     * @param $shop integer identificador de la tienda
     * @return Response
     */
    public function getAvariableProducts($shop)
    {
        $manager = $this->getDoctrine()->getManager();
        $avariableProducts =  $manager->getRepository(ProductsShops::class)->findBy(array("shop"=>$shop));

        $response = array();
        foreach ($avariableProducts as $avariableProduct){
            $temp = array();
            $temp["shopId"]         = $avariableProduct->getShop()->getId();
            $temp["productId"]      = $avariableProduct->getProduct()->getId();
            $temp["productName"]    = $avariableProduct->getProduct()->getName();
            $temp["description"]    = $avariableProduct->getProduct()->getDescription();
            $temp["price"]          = $avariableProduct->getProduct()->getPrice();
            $response[]             = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');
        return new Response($json, 200);
    }

    /**
     * Avariable addresses for current customer
     * @Get("/customersapi/v1/customer/addresses")
     * @return Response
     */
    public function getAvariableAddresses()
    {
        //Get the security token
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        //Get the client and fetch the avarible direction
        $customer = $token->getUser();
        $addresses = $customer->getAddresses();

        //Compose response and return data
        $response = array();
        foreach ($addresses as $address){
            $temp = array();
            $temp["addressId"]  = $address->getId();
            $temp["street"]     = $address->getStreet();
            $temp["zipCode"]    = $address->getZipCode();
            $temp["city"]       = $address->getCity();;
            $response[]         = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');
        return new Response($json, 200);
    }
}