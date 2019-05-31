<?php

namespace AppBundle\Entity;

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
    private $idCliente;

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
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="idDireccion")
     */
    private $pedidos;


    /**
     *
     * @return int
     */
    public function getIdDireccion()
    {
        return $this->idDireccion;
    }

    /**
     * @param string $calle
     *
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * @return string
     */

    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * @param string $codPostal
     *
     * @return Direccion
     */

    public function setCodPostal($codPostal)
    {
        $this->codPostal = $codPostal;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodPostal()
    {
        return $this->codPostal;
    }

    /**
     * @param string $localidad
     *
     * @return Direccion
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @return Cliente
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * @param Cliente $idcliente
     */
    public function setIdCliente($idcliente)
    {
        $this->idCliente = $idcliente;
    }
}
