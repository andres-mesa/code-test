<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ShoppersApiControllerTest
 * Tests that control basic Shoppers API behaviour
 * @package AppBundle\Tests\Controller
 */
class ShoppersApiControllerTest extends WebTestCase
{
    /**
     * This test check that one shopper with good credentials can loggin into Customers API
     */
    public function testShopperCanLoggin()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/shoppersapi/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => 'shopper0@lolamarket.com',
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
     * This test check that one customer with bad credentials cannot loggin into Customers API
     */
    public function testShopperCannotLoggin()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/shoppersapi/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => 'shopper0@lolamarket.com',
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
     * This test checks that a Shopper can access his/hers dispatchOrders
     */
    public function testDispatchOrder()
    {
        $client = $this->shoppersLoggin();

        //Get shopper data
        $client->request('GET', '/shoppersapi/v1/shopper');
        $shopper = json_decode($client->getResponse()->getContent());
        $shopperId = $shopper->shopperId;

        //Get avariable shops
        $client->request('GET', '/shoppersapi/v1/shops');
        $shops = json_decode($client->getResponse()->getContent());

        //Get a random Shop
        $randomShop = array_rand($shops, 1);
        $shopId = $shops[$randomShop]->shopId;

        //Get the Dispatch Order
        $client->request('GET', '/shoppersapi/v1/dispatchorders/'.$shopperId."/shops/".$shopId);
        $response = $client->getResponse();

        //For verification purpose only
        var_dump($response->getContent());

        $this->assertJson($response->getContent());
    }

    /**
     * Auxiliary function that for Shoppers loggin
     * @param string $username
     * @param string $password
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function shoppersLoggin($username = 'shopper0@lolamarket.com', $password = 'lolamarket')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/shoppersapi/login_check',
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
