<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ApiShoppersControllerTest
 * @package AppBundle\Tests\Controller
 */
class ApiShoppersControllerTest extends WebTestCase
{
    /**
     * Test para comprobar que un shopper puede autenticar en la aplicación
     */
    public function testShopperPuedeAutenticar()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/apishoppers/login_check',
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
     * Test para comprobar que un shopper no puede autenticar con datos incorrectos
     */
    public function testShopperNoPuedeAutenticar()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/apishoppers/login_check',
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
     * Test para comprobar que un shopper puede consultar que productos tiene que adquirir en una tienda
     */
    public function testDispatchpedido()
    {
        $client = $this->autenticarShopper();

        //Obtenemos los datos del shopper
        $client->request('GET', '/apishoppers/v1/shopper');
        $shopper = json_decode($client->getResponse()->getContent());
        $idShopper = $shopper->idShopper;

        //Obtenemos las tiendas disponibles
        $client->request('GET', '/apishoppers/v1/tiendas');
        $tiendas = json_decode($client->getResponse()->getContent());

        //De las tiendas disponibles, seleccionamos una
        $tiendaAleatoria = array_rand($tiendas, 1);
        $idTienda = $tiendas[$tiendaAleatoria]->idTienda;

        //Obtenemos los productos que debemos adquirir en la tienda
        $client->request('GET', '/apishoppers/v1/dispatchPedidos/'.$idShopper."/tiendas/".$idTienda);
        $response = $client->getResponse();
        $productosDisponibles = json_decode($response->getContent(), true);

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        //Para facilitar verificacion
        var_dump($response->getContent());

        $this->assertJson($response->getContent());
    }

    /**
     * Función auxiliar para realizar un login en el API de shoppers y obtener el Token de acceso
     * @param string $username
     * @param string $password
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function autenticarShopper($username = 'shopper0@lolamarket.com', $password = 'lolamarket')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/apishoppers/login_check',
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
