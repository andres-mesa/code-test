<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Shopper
 *
 * @ORM\Table(name="shopper")
 * @ORM\Entity
 */
class Shopper
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idShopper", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idshopper;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;


    /**
     * Un Shopper tiene asignadas muchas lineas de pedido.
     * @ORM\OneToMany(targetEntity="LineasPedido", mappedBy="shopper")
     */
    private $lineasPedido;


    public function __construct() {
        $this->lineasPedido = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdshopper(): int
    {
        return $this->idshopper;
    }

    /**
     * @param int $idshopper
     */
    public function setIdshopper(int $idshopper): void
    {
        $this->idshopper = $idshopper;
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
