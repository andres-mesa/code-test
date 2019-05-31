<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TiendaProducto
 *
 * @ORM\Table(name="tiendas_productos")
 * @ORM\Entity
 */
class TiendasProductos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTiendaProducto", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTiendaProducto;

    /**
     * @var \AppBundle\Entity\Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="tiendasProductos")
     * @ORM\JoinColumn(name="idProducto", referencedColumnName="idProducto")
     */
    private $producto;

    /**
     * @var \AppBundle\Entity\Tienda
     *
     * @ORM\ManyToOne(targetEntity="Tienda", inversedBy="tiendasProductos")
     * @ORM\JoinColumn(name="idTienda", referencedColumnName="idTienda")
     */
    private $tienda;

    /**
     * @return int
     */
    public function getIdTiendaProducto(): int
    {
        return $this->idTiendaProducto;
    }

    /**
     * @param int $idTiendaProducto
     */
    public function setIdTiendaProducto(int $idTiendaProducto): void
    {
        $this->idTiendaProducto = $idTiendaProducto;
    }

    /**
     * @return Producto
     */
    public function getProducto(): Producto
    {
        return $this->producto;
    }

    /**
     * @param Producto $producto
     */
    public function setProducto(Producto $producto): void
    {
        $this->producto = $producto;
    }

    /**
     * @return Tienda
     */
    public function getTienda(): Tienda
    {
        return $this->tienda;
    }

    /**
     * @param Tienda $tienda
     */
    public function setTienda(Tienda $tienda): void
    {
        $this->tienda = $tienda;
    }
}
