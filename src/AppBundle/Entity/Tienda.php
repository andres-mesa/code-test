<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tienda
 *
 * @ORM\Table(name="tienda")
 * @ORM\Entity
 */
class Tienda
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTienda", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtienda;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;


    /**
     * Una Tienda se asocia con muchos productos.
     * @ORM\OneToMany(targetEntity="TiendasProductos", mappedBy="tienda")
     */
    private $tiendasProductos;

    /**
     * Una Tienda tiene lineas de pedido.
     * @ORM\OneToMany(targetEntity="LineasPedido", mappedBy="tienda")
     */
    private $lineasPedido;

    /**
     * Tienda constructor.
     */
    public function __construct() {
        $this->tiendasProductos = new ArrayCollection();
        $this->lineasPedido = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdtienda(): int
    {
        return $this->idtienda;
    }

    /**
     * @param int $idtienda
     */
    public function setIdtienda(int $idtienda): void
    {
        $this->idtienda = $idtienda;
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
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
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
}
