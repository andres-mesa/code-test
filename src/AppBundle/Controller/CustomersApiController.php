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
     * API action to persist a new Order
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

        //Create the new Order
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

            return new JsonResponse(array("status" => "ok", "message"=>"Order Ready"));

        } catch (\Exception $e) {
            $manager->remove($order);
            $manager->flush();
            throw $e;
        }
    }


    /**
     * Available shops
     * @Get("/customersapi/v1/shops")
     * @return Response
     */
    public function getAvailableShops()
    {
        $manager = $this->getDoctrine()->getManager();
        $shops =  $manager->getRepository(Shop::class)->findAll();

        $response = array();
        foreach ($shops as $shop){
            $temp = array();
            $temp["shopId"] = $shop->getId();
            $temp["name"] = $shop->getName();
            $response[] = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');

        return new Response($json, 200);
    }

    /**
     * Available products in given shop
     * @Get("/customersapi/v1/shops/{shop}/products")
     * @param $shop integer shop id
     * @return Response
     */
    public function getAvailableProducts($shop)
    {
        $manager = $this->getDoctrine()->getManager();
        $availableProducts =  $manager->getRepository(ProductsShops::class)->findBy(array("shop"=>$shop));

        $response = array();
        foreach ($availableProducts as $availableProduct){
            $temp = array();
            $temp["shopId"]         = $availableProduct->getShop()->getId();
            $temp["productId"]      = $availableProduct->getProduct()->getId();
            $temp["productName"]    = $availableProduct->getProduct()->getName();
            $temp["description"]    = $availableProduct->getProduct()->getDescription();
            $temp["price"]          = $availableProduct->getProduct()->getPrice();
            $response[]             = $temp;
        }

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($response, 'json');
        return new Response($json, 200);
    }

    /**
     * Available addresses for current customer
     * @Get("/customersapi/v1/customer/addresses")
     * @return Response
     */
    public function getAvailableAddresses()
    {
        //Get the security token
        $token = $this->container->get('security.token_storage')->getToken();

        if(!$token || !is_object($user = $token->getUser())){
            return new JsonResponse(array('code' => '400', 'content'=> 'Usuario no encontrado'));
        }

        //Get the client and fetch the available directions
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
