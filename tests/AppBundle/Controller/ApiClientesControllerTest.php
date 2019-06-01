<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiClientesControllerTest extends WebTestCase
{
    public function testClientePuedeAutenticar()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/apiclientes/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => 'cliente0@lolamarket.com',
                'password' => 'lolamarket',
            ))
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey("token",$data);
    }

    public function testClienteNoPuedeAutenticar()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/apiclientes/login_check',
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

    public function testPostpedido()
    {
        $client = $this->autenticarCliente();
        $client->request(
            'POST',
            '/apiclientes/v1/pedido',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                      "idCliente": 1,
                      "direccionCompleta": "Calle 208",
                      "fechaEntrega": "2019-06-18",
                      "idFranjaEntrega": 10,
                      "origenPedido": "iOS",
                      "productos": [
                        {
                          "id": 1,
                          "cantidad": 4,
                          "tienda": 8
                        },
                        {
                          "id": 2,
                          "cantidad": 3,
                          "tienda": 9
                        },
                        {
                          "id": 3,
                          "cantidad": 4,
                          "tienda": 1
                        }
                      ]
                    }'
        );

        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
    }



    protected function autenticarCliente($username = 'cliente0@lolamarket.com', $password = 'lolamarket')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/apiclientes/login_check',
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
