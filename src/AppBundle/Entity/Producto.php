<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Productos
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity
 */
class Producto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProducto", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idproducto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $precio = '0.00';

    /**
     * Un Producto se encuentra en muchas lineas de pedido.
     * @ORM\OneToMany(targetEntity="PedidosProductos", mappedBy="idProducto")
     */
    private $pedidosProductos;

    /**
     * Muchos Productos estan en muchas tiendas.
     * @ORM\ManyToMany(targetEntity="Tienda", inversedBy="productos")
     * @ORM\JoinTable(name="productos_tiendas")
     */
    private $tiendas;

    public function __construct() {
        $this->tiendas = new ArrayCollection();
    }

    /**
     * @param int $idproducto
     */
    public function setIdproducto($idproducto)
    {
        $this->idproducto = $idproducto;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param string $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return int
     */
    public function getIdproducto()
    {
        return $this->idproducto;
    }
}
