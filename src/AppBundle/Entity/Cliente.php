<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente/Usuario de la aplicacion
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity
 */
class Cliente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCliente", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido1", type="string", length=255, nullable=true)
     */
    private $apellido1;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido2", type="string", length=255, nullable=true)
     */
    private $apellido2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * Un Cliente tiene muchos pedidos.
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="cliente")
     */
    private $pedidos;

    /**
     * Un Cliente tiene muchas direcciones.
     * @ORM\OneToMany(targetEntity="Direccion", mappedBy="cliente")
     */
    private $direcciones;


    /**
     * Constructor de clase
     */
    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
        $this->direcciones = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdCliente(): int
    {
        return $this->idCliente;
    }

    /**
     * @param int $idCliente
     */
    public function setIdCliente(int $idCliente): void
    {
        $this->idCliente = $idCliente;
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
    public function getApellido1(): string
    {
        return $this->apellido1;
    }

    /**
     * @param string $apellido1
     */
    public function setApellido1(string $apellido1): void
    {
        $this->apellido1 = $apellido1;
    }

    /**
     * @return string
     */
    public function getApellido2(): string
    {
        return $this->apellido2;
    }

    /**
     * @param string $apellido2
     */
    public function setApellido2(string $apellido2): void
    {
        $this->apellido2 = $apellido2;
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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

    /**
     * @return mixed
     */
    public function getDirecciones()
    {
        return $this->direcciones;
    }

    /**
     * @param mixed $direcciones
     */
    public function setDirecciones($direcciones): void
    {
        $this->direcciones = $direcciones;
    }


}
