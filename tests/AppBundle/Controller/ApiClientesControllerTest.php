<?php

namespace AppBundle\Tests\Controller;

use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use JMS\Serializer\Builder;

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

        //Obtenemos las tiendas disponibles
        $client->request('GET', '/apiclientes/v1/tiendas');
        $tiendas = json_decode($client->getResponse()->getContent());

        //De las tiendas disponibles, seleccionamos una y vemos que productos tiene disponibles
        $tiendaAleatoria = array_rand($tiendas, 1);
        $idTienda = $tiendas[$tiendaAleatoria]->idTienda;

        //Obtenemos los productos disponibles en las tiendas
        $client->request('GET', '/apiclientes/v1/tiendas/'.$idTienda."/productos");
        $response = $client->getResponse();
        $productosDisponibles = json_decode($response->getContent(), true);

        //Obtenemos direcciones disponibles del cliente
        $client->request('GET', '/apiclientes/v1/cliente/direcciones');
        $response = $client->getResponse();
        $direcciones = json_decode($response->getContent(), true);

        $algunosProductos = array_rand($productosDisponibles, rand(2,count($productosDisponibles)));
        $unaDireccion = array_rand($direcciones, 1);

        //Componemos la peticion de pedido
        $pedido = array();
        $pedido["direccion"] = $direcciones[$unaDireccion]["idDireccion"];
        $pedido["telefono"] = "918493122";
        $pedido["fechaEntrega"] = "2019-07-18";
        $pedido["idFranjaEntrega"] = 10;
        $pedido["origenPedido"] = "iOS";
        $pedido["productos"] = array();


        foreach ($algunosProductos as $productoDisponible){
            $temp = array();
            $temp["producto"] = $productosDisponibles[$productoDisponible]["idProducto"];
            $temp["cantidad"]   = rand(1,5);
            $temp["tienda"]     = $idTienda;
            $pedido["productos"][] = $temp;
        }

        $jsonPedido = json_encode($pedido);

        $client->request(
            'POST',
            '/apiclientes/v1/pedido',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $jsonPedido
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
