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
     * @ORM\OneToMany(targetEntity="LineasPedido", mappedBy="producto")
     */
    private $lineasPedido;

    /**
     * Un Producto se encuentra en muchas Tiendas.
     * @ORM\OneToMany(targetEntity="TiendasProductos", mappedBy="producto")
     */
    private $tiendasProductos;

    /**
     * Producto constructor.
     */
    public function __construct() {
        $this->tiendasProductos = new ArrayCollection();
        $this->lineasPedido = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdproducto(): int
    {
        return $this->idproducto;
    }

    /**
     * @param int $idproducto
     */
    public function setIdproducto(int $idproducto): void
    {
        $this->idproducto = $idproducto;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getPrecio(): string
    {
        return $this->precio;
    }

    /**
     * @param string $precio
     */
    public function setPrecio(string $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getLineasPedido()
    {
        return $this->lineasPedido;
    }

    /**
     * @param mixed $lineasPedido
     */
    public function setLineasPedido($lineasPedido): void
    {
        $this->lineasPedido = $lineasPedido;
    }

    /**
     * @return mixed
     */
    public function getTiendasProductos()
    {
        return $this->tiendasProductos;
    }

    /**
     * @param mixed $tiendasProductos
     */
    public function setTiendasProductos($tiendasProductos): void
    {
        $this->tiendasProductos = $tiendasProductos;
    }
}
