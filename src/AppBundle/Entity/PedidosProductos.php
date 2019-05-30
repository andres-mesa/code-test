<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidosProductos
 *
 * @ORM\Table(name="pedidos_productos", indexes={@ORM\Index(name="FK_pedidos_productos_pedidos", columns={"idPedido"}), @ORM\Index(name="FK_pedidos_productos_productos", columns={"idProducto"}), @ORM\Index(name="FK_pedidos_productos_tienda", columns={"idTienda"}), @ORM\Index(name="FK_pedidos_productos_shopper", columns={"idShopper"})})
 * @ORM\Entity
 */
class PedidosProductos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="unidades", type="integer", nullable=false)
     */
    private $unidades = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="idPedidoProducto", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpedidoproducto;

    /**
     * @var \AppBundle\Entity\Pedido
     *
     * @ORM\ManyToOne(targetEntity="Pedido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPedido", referencedColumnName="idPedido")
     * })
     */
    private $idpedido;

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
     * @var \AppBundle\Entity\Shopper
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shopper")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idShopper", referencedColumnName="idShopper")
     * })
     */
    private $idshopper;

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
    public function getUnidades() {
        return $this->unidades;
    }

    /**
     * @param int $unidades
     */
    public function setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    /**
     * @return int
     */
    public function getIdpedidoproducto() {
        return $this->idpedidoproducto;
    }

    /**
     * @param int $idpedidoproducto
     */
    public function setIdpedidoproducto($idpedidoproducto) {
        $this->idpedidoproducto = $idpedidoproducto;
    }

    /**
     * @return Pedido
     */
    public function getIdpedido() {
        return $this->idpedido;
    }

    /**
     * @param Pedido $idpedido
     */
    public function setIdpedido($idpedido) {
        $this->idpedido = $idpedido;
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
     * @return Shopper
     */
    public function getIdshopper() {
        return $this->idshopper;
    }

    /**
     * @param Shopper $idshopper
     */
    public function setIdshopper($idshopper) {
        $this->idshopper = $idshopper;
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

