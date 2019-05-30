<?php

namespace AppBundle\Entity;

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
     * @return int
     */
    public function getIdtienda() {
        return $this->idtienda;
    }

    /**
     * @param int $idtienda
     */
    public function setIdtienda($idtienda) {
        $this->idtienda = $idtienda;
    }
    /**
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
}

