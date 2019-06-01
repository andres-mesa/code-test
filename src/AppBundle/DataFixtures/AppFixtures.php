<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Direccion;
use AppBundle\Entity\LineasPedido;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Shopper;
use AppBundle\Entity\Tienda;
use AppBundle\Entity\TiendasProductos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //Crear 20 clientes y sus direcciones
        for ($i = 0; $i < 20; $i++) {
            $cliente = new Cliente();
            $cliente->setNombre("Nombre ".$i);
            $cliente->setApellido1("Apellido ".$i);
            $cliente->setApellido2("Apellido ".$i);
            $cliente->setEmail("email".$i."@lolamarket.com");
            $password = self::generateRandomString(50);
            $cliente->setPassword($password);


            $direccion = new Direccion();
            $direccion->setCliente($cliente);
            $direccion->setCalle("Calle ". $i);
            $direccion->setCodPostal(strval(28000 + $i));
            $direccion->setLocalidad("Localidad ". $i);

            $manager->persist($cliente);
            $manager->persist($direccion);
            $manager->flush();
        }

        //Crear 20 Shoppers
        for ($i = 0; $i < 20; $i++) {
            $shopper = new Shopper();
            $shopper->setNombre("Nombre ".$i);
            $manager->persist($shopper);
        }

        //Crear 5 Tiendas
        for ($i = 0; $i < 5; $i++) {
            $tienda = new Tienda();
            $tienda->setNombre("Nombre ".$i);
            $tienda->setDireccion("Direccion ".$i);
            $manager->persist($tienda);
        }

        $manager->flush();

        //Crear 50 productos y relacionarlos con algunas tiendas
        for ($i = 0; $i < 50; $i++) {
            $producto = new Producto();
            $producto->setNombre("Producto " . $i);
            $producto->setDescripcion("Descripción ".$i);
            $producto->setPrecio(mt_rand (0*10, 50*10) / 10);
            $manager->persist($producto);
            $manager->flush();

            //Seleccionamos las tiendas
            $tiendas =  $manager->getRepository(Tienda::class)->findAll();
            $tiendasAleatorias = array_rand($tiendas, rand(1,count($tiendas)));

            //Creamos las relaciones
            if(is_array($tiendasAleatorias)){
                foreach ($tiendasAleatorias as $tienda){
                    $tiendaProducto = new TiendasProductos();
                    $tiendaProducto->setProducto($producto);
                    $tiendaProducto->setTienda($tiendas[$tienda]);
                    $manager->persist($tiendaProducto);
                    $manager->flush();
                }
            }else{
                $tiendaProducto = new TiendasProductos();
                $tiendaProducto->setProducto($producto);
                $tiendaProducto->setTienda($tiendas[$tiendasAleatorias]);
                $manager->persist($tiendaProducto);
                $manager->flush();
            }
        }

        //Crear 10 Pedidos
        for ($i = 0; $i < 10; $i++) {

            $pedido = new Pedido();
            $pedido->setTelefono(strval(918493100 + $i));

            //Indicamos la fecha del pedido y la fecha de entrega
            $hoy = new \DateTime('now');
            $pedido->setFechaCompra($hoy);
            $pedido->setFechaEntrega($hoy->add(new \DateInterval('P1D')));
            $pedido->setOrigen("iOS");

            //Obtenemos un cliente aleatorio
            $clientes =  $manager->getRepository(Cliente::class)->findAll();
            $unClienteAleatorio = array_rand($clientes, 1);
            $pedido->setCliente($clientes[$unClienteAleatorio]);

            //Una direccion aleatoria de ese cliente
            $direcciones = $manager->getRepository(Direccion::class)->findBy(array("cliente"=>$pedido->getCliente()->getIdCliente()));
            $unaDireccionAleatoriaAleatorio = array_rand($direcciones, 1);
            $pedido->setDireccion($direcciones[$unaDireccionAleatoriaAleatorio]);

            $nombreCompleto = $pedido->getCliente()->getNombre() . " " .$pedido->getCliente()->getApellido1() . " " .$pedido->getCliente()->getApellido2();
            $pedido->setNombreCompleto($nombreCompleto);

            $email = $pedido->getCliente()->getEmail();
            $pedido->setEmail($email);

            $direccionEntrega = $pedido->getDireccion()->getCalle() . " " . $pedido->getDireccion()->getLocalidad() . " " . $pedido->getDireccion()->getCodPostal();
            $pedido->setDireccionEntrega($direccionEntrega);

            $pedido->setIdFranjaEntrega(rand(0,10));
            $pedido->setImporteTotal(0.0);

            $manager->persist($pedido);
            $manager->flush();

            //Asignamos unas cuantas lineas de pedido
            $tiendas =  $manager->getRepository(Tienda::class)->findAll();
            $tiendasAleatorias = array_rand($tiendas, rand(2,count($tiendas)));

            foreach ($tiendasAleatorias as $tiendasAleatoria){
                $tienda = $tiendas[$tiendasAleatoria];
                $productosDisponiblesEnTienda = $manager->getRepository(TiendasProductos::class)->findBy(array("tienda"=>$tienda));
                $algunosProductosDeLaTienda = array_rand($productosDisponiblesEnTienda, rand(2,count($productosDisponiblesEnTienda)));

                foreach ($algunosProductosDeLaTienda as $productoTienda){
                    $lineaPedido = new LineasPedido();
                    $lineaPedido->setPedido($pedido);
                    $lineaPedido->setTienda($tienda);
                    $lineaPedido->setUnidades(rand(1,10));
                    $lineaPedido->setProducto($productosDisponiblesEnTienda[$productoTienda]->getProducto());
                    $manager->persist($lineaPedido);
                    $manager->flush();
                }
            }
        }

        //Asignamos a los shopper lineas de pedido
        $tiendas  =  $manager->getRepository(Tienda::class)->findAll();
        $shoppers =  $manager->getRepository(Shopper::class)->findAll();

        //Obtenemos una tienda aleatoria, buscamos las lineas que lo componen y asignamos al shopper si no lo tienen
        foreach ($shoppers as $shopper){
            $tiendaAleatoria = array_rand($tiendas, 1);
            $lineasPedidoSinShopper = $manager->getRepository(LineasPedido::class)->findBy(array("tienda"=>$tiendas[$tiendaAleatoria], "shopper"=> null));
            foreach ($lineasPedidoSinShopper as $lineaPedido){
                $lineaPedido->setShopper($shopper);
                $manager->persist($lineaPedido);
            }
            $manager->flush();
        }
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}