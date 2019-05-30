<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TiendaProducto
 *
 * @ORM\Table(name="tienda_producto", indexes={@ORM\Index(name="FK_tienda_producto_tienda", columns={"idTienda"}), @ORM\Index(name="FK_tienda_producto_productos", columns={"idProducto"})})
 * @ORM\Entity
 */
class TiendaProducto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTiendaProducto", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtiendaproducto;

    /**
     * @var \AppBundle\Entity\Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProducto", referencedColumnName="idProducto")
     * })
     */
    private $idproducto;

    /**
     * @var \AppBundle\Entity\Tienda
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tienda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTienda", referencedColumnName="idTienda")
     * })
     */
    private $idtienda;

    /**
     * @return int
     */
    public function getIdtiendaprodcuto() {
        return $this->idtiendaprodcuto;
    }

    /**
     * @param int $idtiendaprodcuto
     */
    public function setIdtiendaproducto($idtiendaprodcuto) {
        $this->idtiendaprodcuto = $idtiendaprodcuto;
    }

    /**
     * @return Producto
     */
    public function getIdproducto() {
        return $this->idproducto;
    }

    /**
     * @param Producto $idproducto
     */
    public function setIdproducto($idproducto) {
        $this->idproducto = $idproducto;
    }

    /**
     * @return Tienda
     */
    public function getIdtienda() {
        return $this->idtienda;
    }

    /**
     * @param Tienda $idtienda
     */
    public function setIdtienda($idtienda) {
        $this->idtienda = $idtienda;
    }


}

