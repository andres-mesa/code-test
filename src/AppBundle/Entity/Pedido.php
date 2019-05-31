<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidad que representa un pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity
 */
class Pedido
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPedido", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPedido;

    /**
     * Los pedidos tienen un cliente
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="idCliente")
     */
    private $cliente;

    /**
     * Los pedidos tienen una dirección
     * @ORM\ManyToOne(targetEntity="Direccion", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idDireccion", referencedColumnName="idDireccion")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreCompleto", type="string", length=255, nullable=true)
     */
    private $nombreCompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer", nullable=false)
     */
    private $telefono = '000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="direccionEntrega", type="string", length=255, nullable=true)
     */
    private $direccionEntrega;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCompra", type="datetime", nullable=true)
     */
    private $fechaCompra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrega", type="date", nullable=true)
     */
    private $fechaEntrega;

    /**
     * @var integer
     *
     * @ORM\Column(name="idFranjaEntrega", type="integer", nullable=true)
     */
    private $idFranjaEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="importeTotal", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $importeTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="origenPedido", type="integer", length=1, nullable=true)
     */
    private $origen;

    /**
     * Un Pedido tiene muchas lineas de pedido.
     * @ORM\OneToMany(targetEntity="LineasPedido", mappedBy="pedido")
     */
    private $lineasPedido;

    /**
     * Constructor de clase
     */
    public function __construct()
    {
        $this->lineasPedido = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdPedido(): int
    {
        return $this->idPedido;
    }

    /**
     * @param int $idPedido
     */
    public function setIdPedido(int $idPedido): void
    {
        $this->idPedido = $idPedido;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getNombreCompleto(): string
    {
        return $this->nombreCompleto;
    }

    /**
     * @param string $nombreCompleto
     */
    public function setNombreCompleto(string $nombreCompleto): void
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getDireccionEntrega(): string
    {
        return $this->direccionEntrega;
    }

    /**
     * @param string $direccionEntrega
     */
    public function setDireccionEntrega(string $direccionEntrega): void
    {
        $this->direccionEntrega = $direccionEntrega;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCompra(): \DateTime
    {
        return $this->fechaCompra;
    }

    /**
     * @param \DateTime $fechaCompra
     */
    public function setFechaCompra(\DateTime $fechaCompra): void
    {
        $this->fechaCompra = $fechaCompra;
    }

    /**
     * @return \DateTime
     */
    public function getFechaEntrega(): \DateTime
    {
        return $this->fechaEntrega;
    }

    /**
     * @param \DateTime $fechaEntrega
     */
    public function setFechaEntrega(\DateTime $fechaEntrega): void
    {
        $this->fechaEntrega = $fechaEntrega;
    }

    /**
     * @return int
     */
    public function getIdFranjaEntrega(): int
    {
        return $this->idFranjaEntrega;
    }

    /**
     * @param int $idFranjaEntrega
     */
    public function setIdFranjaEntrega(int $idFranjaEntrega): void
    {
        $this->idFranjaEntrega = $idFranjaEntrega;
    }

    /**
     * @return string
     */
    public function getImporteTotal(): string
    {
        return $this->importeTotal;
    }

    /**
     * @param string $importeTotal
     */
    public function setImporteTotal(string $importeTotal): void
    {
        $this->importeTotal = $importeTotal;
    }

    /**
     * @return string
     */
    public function getOrigen(): string
    {
        return $this->origen;
    }

    /**
     * @param string $origen
     */
    public function setOrigen(string $origen): void
    {
        $this->origen = $origen;
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
