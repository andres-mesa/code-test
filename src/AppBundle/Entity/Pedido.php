<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidad que representa un pedido
 *
 * @ORM\Table(name="pedido", indexes={@ORM\Index(name="idCliente", columns={"idCliente"})})
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
     * @var \AppBundle\Entity\Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="idCliente")
     */
    private $idCliente;

    /**
     * @var \AppBundle\Entity\Direccion
     *
     * @ORM\ManyToOne(targetEntity="Direccion", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idDireccion", referencedColumnName="idDireccion")
     */
    private $idDireccion;

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
     * Un Pedido tiene muchas lineas de producto.
     * @ORM\OneToMany(targetEntity="PedidosProductos", mappedBy="pedido")
     */
    private $pedidosProductos;


    /**
     * Constructor de clase
     */
    public function __construct()
    {
        $this->pedidosProductos = new ArrayCollection();
    }

    /**
     * @return Cliente
     */

    public function getIdcliente()
    {
        return $this->idCliente;
    }

    /**
     * @param Cliente $idcliente
     */
    public function setIdcliente($idcliente)
    {
        $this->idCliente = $idcliente;
    }

    /**
     * @return string
     */
    public function getNombrecompleto()
    {
        return $this->nombreCompleto;
    }

    /**
     * @param string $nombreCompleto
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return Direccion
     */
    public function getIdDireccion()
    {
        return $this->idDireccion;
    }

    /**
     * @param string $direccionEntrega
     */
    public function setDireccionentrega($direccionEntrega)
    {
        $this->direccionEntrega = $direccionEntrega;
    }

    /**
     * @return string
     */
    public function getDireccionEntrega()
    {
        return $this->direccionEntrega;
    }

    /**
     * @param integer $direccionEntrega
     */
    public function setIdDireccion($direccionEntrega)
    {
        $this->direccionEntrega = $direccionEntrega;
    }

    /**
     * @return \DateTime
     */
    public function getFechacompra()
    {
        return $this->fechaCompra;
    }

    /**
     * @param \DateTime $fechaCompra
     */
    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;
    }

    /**
     * @return \DateTime
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * @param \DateTime $fechaEntrega
     */
    public function setFechaEntrega($fechaEntrega)
    {
        $this->fechaEntrega = $fechaEntrega;
    }

    /**
     * @return int
     */
    public function getIdfranjaentrega()
    {
        return $this->idfranjaEntrega;
    }

    /**
     * @param int $idFranjaEntrega
     */
    public function setIdfranjaentrega($idFranjaEntrega)
    {
        $this->idFranjaEntrega = $idFranjaEntrega;
    }

    /**
     * @return string
     */
    public function getImportetotal()
    {
        return $this->importeTotal;
    }

    /**
     * @param string $importeTotal
     */
    public function setImportetotal($importeTotal)
    {
        $this->importeTotal = $importeTotal;
    }

    /**
     * @return int
     */
    public function getIdpedido()
    {
        return $this->idPedido;
    }

    /**
     * @param int $idpedido
     */
    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;
    }

    /**
     * @return string
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * @param string $origen
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }
}
