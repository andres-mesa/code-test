<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testPostpedido()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/pedido',
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

    public function testDispatchpedido()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/dispatchPedido');
    }

}
