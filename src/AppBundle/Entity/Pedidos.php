<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="pedidos", indexes={@ORM\Index(name="idCliente", columns={"idCliente"})})
 * @ORM\Entity
 */
class Pedidos
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombreCompleto", type="string", length=255, nullable=true)
     */
    private $nombrecompleto;

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
    private $direccionentrega;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCompra", type="datetime", nullable=true)
     */
    private $fechacompra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrega", type="date", nullable=true)
     */
    private $fechaentrega;

    /**
     * @var integer
     *
     * @ORM\Column(name="idFranjaEntrega", type="integer", nullable=true)
     */
    private $idfranjaentrega;

    /**
     * @var string
     *
     * @ORM\Column(name="importeTotal", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $importetotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPedido", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpedido;

    /**
     * @var \AppBundle\Entity\Clientes
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clientes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCliente", referencedColumnName="idCliente")
     * })
     */
    private $idcliente;

    /**
     * @return string
     */
    public function getNombrecompleto() {
        return $this->nombrecompleto;
    }

    /**
     * @param string $nombrecompleto
     */
    public function setNombrecompleto($nombrecompleto) {
        $this->nombrecompleto = $nombrecompleto;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getDireccionentrega() {
        return $this->direccionentrega;
    }

    /**
     * @param string $direccionentrega
     */
    public function setDireccionentrega($direccionentrega) {
        $this->direccionentrega = $direccionentrega;
    }

    /**
     * @return \DateTime
     */
    public function getFechacompra() {
        return $this->fechacompra;
    }

    /**
     * @param \DateTime $fechacompra
     */
    public function setFechacompra($fechacompra) {
        $this->fechacompra = $fechacompra;
    }

    /**
     * @return \DateTime
     */
    public function getFechaentrega() {
        return $this->fechaentrega;
    }

    /**
     * @param \DateTime $fechaentrega
     */
    public function setFechaentrega($fechaentrega) {
        $this->fechaentrega = $fechaentrega;
    }

    /**
     * @return int
     */
    public function getIdfranjaentrega() {
        return $this->idfranjaentrega;
    }

    /**
     * @param int $idfranjaentrega
     */
    public function setIdfranjaentrega($idfranjaentrega) {
        $this->idfranjaentrega = $idfranjaentrega;
    }

    /**
     * @return string
     */
    public function getImportetotal() {
        return $this->importetotal;
    }

    /**
     * @param string $importetotal
     */
    public function setImportetotal($importetotal) {
        $this->importetotal = $importetotal;
    }

    /**
     * @return int
     */
    public function getIdpedido() {
        return $this->idpedido;
    }

    /**
     * @param int $idpedido
     */
    public function setIdpedido($idpedido) {
        $this->idpedido = $idpedido;
    }

    /**
     * @return Clientes
     */
    public function getIdcliente() {
        return $this->idcliente;
    }

    /**
     * @param Clientes $idcliente
     */
    public function setIdcliente($idcliente) {
        $this->idcliente = $idcliente;
    }


}

