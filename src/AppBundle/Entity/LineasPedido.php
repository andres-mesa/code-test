<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * LineasPedido
 *
 * @ORM\Table(name="lineas_pedido")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class LineasPedido
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idLineaPedido", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idLineaPedido;

    /**
     * @var integer
     *
     * @ORM\Column(name="unidades", type="integer", nullable=false)
     */
    private $unidades = '1';

    /**
     * Muchas lineas de pedido componen un pedido.
     * @ManyToOne(targetEntity="Pedido", inversedBy="lineasPedido")
     * @JoinColumn(name="idPedido", referencedColumnName="idPedido")
     */
    private $pedido;

    /**
     * Muchas lineas de pedido tienen un producto.
     * @ManyToOne(targetEntity="Producto", inversedBy="lineasPedido")
     * @JoinColumn(name="idProducto", referencedColumnName="idProducto")
     */
    private $producto;

    /**
     * Muchas lineas de pedido estan asignadas a un shopper.
     * @ManyToOne(targetEntity="Shopper", inversedBy="lineasPedido")
     * @JoinColumn(name="idShopper", referencedColumnName="idShopper")
     */
    private $shopper;

    /**
     * Muchas lineas de pedido tienen una tienda en la que realizar la compra.
     * @ManyToOne(targetEntity="Tienda", inversedBy="lineasPedido")
     * @JoinColumn(name="idTienda", referencedColumnName="idTienda")
     */
    private $tienda;

    /**
     * @return int
     */
    public function getIdLineaPedido(): int
    {
        return $this->idLineaPedido;
    }

    /**
     * @param int $idLineaPedido
     */
    public function setIdLineaPedido(int $idLineaPedido): void
    {
        $this->idLineaPedido = $idLineaPedido;
    }

    /**
     * @return int
     */
    public function getUnidades(): int
    {
        return $this->unidades;
    }

    /**
     * @param int $unidades
     */
    public function setUnidades(int $unidades): void
    {
        $this->unidades = $unidades;
    }

    /**
     * @return mixed
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * @param mixed $pedido
     */
    public function setPedido($pedido): void
    {
        $this->pedido = $pedido;
    }

    /**
     * @return mixed
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param mixed $producto
     */
    public function setProducto($producto): void
    {
        $this->producto = $producto;
    }

    /**
     * @return mixed
     */
    public function getShopper()
    {
        return $this->shopper;
    }

    /**
     * @param mixed $shopper
     */
    public function setShopper($shopper): void
    {
        $this->shopper = $shopper;
    }

    /**
     * @return mixed
     */
    public function getTienda()
    {
        return $this->tienda;
    }

    /**
     * @param mixed $tienda
     */
    public function setTienda($tienda): void
    {
        $this->tienda = $tienda;
    }


    private function actualizarValorCarro(){

    }
}
