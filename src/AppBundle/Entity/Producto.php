<?php

namespace AppBundle\Entity;

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
     * @var integer
     *
     * @ORM\Column(name="idProducto", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproducto;

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
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getPrecio() {
        return $this->precio;
    }

    /**
     * @param string $precio
     */
    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    /**
     * @return int
     */
    public function getIdproducto() {
        return $this->idproducto;
    }

    /**
     * @param int $idproducto
     */
    public function setIdproducto($idproducto) {
        $this->idproducto = $idproducto;
    }


}

