<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion de entrega de un pedido
 * @ORM\Entity
 * @ORM\Table(name="direccion")
 */
class Direccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDireccion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idDireccion;

    /**
     * @var \AppBundle\Entity\Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="direcciones")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="idCliente")
     */
    private $cliente;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="codPostal", type="string", length=5)
     */
    private $codPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255)
     */
    private $localidad;

    /**
     * Una Direccion tiene muchos pedidos.
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="direccion")
     */
    private $pedidos;

    public function __construct()
    {
       $this->pedidos = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdDireccion(): int
    {
        return $this->idDireccion;
    }

    /**
     * @param int $idDireccion
     */
    public function setIdDireccion(int $idDireccion): void
    {
        $this->idDireccion = $idDireccion;
    }

    /**
     * @return Cliente
     */
    public function getCliente(): Cliente
    {
        return $this->cliente;
    }

    /**
     * @param Cliente $cliente
     */
    public function setCliente(Cliente $cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return string
     */
    public function getCalle(): string
    {
        return $this->calle;
    }

    /**
     * @param string $calle
     */
    public function setCalle(string $calle): void
    {
        $this->calle = $calle;
    }

    /**
     * @return string
     */
    public function getCodPostal(): string
    {
        return $this->codPostal;
    }

    /**
     * @param string $codPostal
     */
    public function setCodPostal(string $codPostal): void
    {
        $this->codPostal = $codPostal;
    }

    /**
     * @return string
     */
    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    /**
     * @param string $localidad
     */
    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;
    }

    /**
     * @return mixed
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * @param mixed $pedidos
     */
    public function setPedidos($pedidos): void
    {
        $this->pedidos = $pedidos;
    }



}
