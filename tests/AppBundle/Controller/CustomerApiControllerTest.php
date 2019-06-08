<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CustomerApiControllerTest
 * Tests Customer API basic behaviour
 * @package AppBundle\Tests\Controller
 */
class CustomerApiControllerTest extends WebTestCase
{

    /**
     * This test check that one customer with good credentials can login into Customers API
     */
    public function testCustomerCanLogin()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/customersapi/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => 'customer0@lolamarket.com',
                'password' => 'lolamarket',
            ))
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey("token",$data);
    }

    /**
     * This test check that one customer with bad credentials cannot login into Customers API
     */
    public function testCustomerCannotLogin()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/customersapi/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => 'email0@lolamarket.com',
                'password' => 'badpassword',
            ))
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertArrayNotHasKey("token",$data);
        $this->assertEquals("401",$data["code"]);
    }

    /**
     * This test verifies that the new order process is completed and ok
     */
    public function testPostOrder()
    {
        $client = $this->customerLogin();

        //Get available shops
        $client->request('GET', '/customersapi/v1/shops');
        $shops = json_decode($client->getResponse()->getContent());

        //Get a random Shop
        $randomShop = array_rand($shops, 1);
        $shopId = $shops[$randomShop]->shopId;

        //Get products available in the random shop
        $client->request('GET', '/customersapi/v1/shops/'.$shopId."/products");
        $response = $client->getResponse();
        $availableProducts = json_decode($response->getContent(), true);

        //Get a valid customer address
        $client->request('GET', '/customersapi/v1/customer/addresses');
        $response = $client->getResponse();
        $addresses = json_decode($response->getContent(), true);

        $someProducts = array_rand($availableProducts, rand(2,count($availableProducts)));
        $oneAddress = array_rand($addresses, 1);

        //New order array
        $order = array();
        $order["addressId"] = $addresses[$oneAddress]["addressId"];
        $order["phone"] = "918493122";
        $order["deliveryDate"] = "2019-07-18";
        $order["deliverySlotId"] = 10;
        $order["origin"] = "iOS";
        $order["products"] = array();


        foreach ($someProducts as $availableProduct){
            $temp = array();
            $temp["productId"]     = $availableProducts[$availableProduct]["productId"];
            $temp["units"]         = rand(1,5);
            $temp["shopId"]        = $shopId;
            $order["products"][]   = $temp;
        }

        $orderJson = json_encode($order);

        $client->request(
            'POST',
            '/customersapi/v1/order',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $orderJson
        );



        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        //For verification purpose only
        var_dump($response->getContent());
    }


    /**
     * Performs a customer Login
     * @param string $username
     * @param string $password
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function customerLogin($username = 'customer0@lolamarket.com', $password = 'lolamarket')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/customersapi/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => $username,
                'password' => $password,
            ))
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}
