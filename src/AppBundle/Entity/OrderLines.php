<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents an Order order line
 *
 * @ORM\Table(name="order_lines")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class OrderLines
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="units", type="integer", nullable=false)
     */
    private $units = '1';

    /**
     * Many order lines compose an order
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderLines")
     * @ORM\JoinColumn(name="orderId", referencedColumnName="id")
     */
    private $order;

    /**
     * Many order lines has a product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="orderLines")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     */
    private $product;

    /**
     * Many order lines belongs to a shopper
     * @ORM\ManyToOne(targetEntity="Shopper", inversedBy="orderLines")
     * @ORM\JoinColumn(name="shopperId", referencedColumnName="id")
     */
    private $shopper;

    /**
     * Many order lines belongs to a shop
     * @ORM\ManyToOne(targetEntity="Shop", inversedBy="orderLines")
     * @ORM\JoinColumn(name="shopId", referencedColumnName="id")
     */
    private $shop;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUnits(): int
    {
        return $this->units;
    }

    /**
     * @param int $units
     */
    public function setUnits(int $units): void
    {
        $this->units = $units;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return Shopper
     */
    public function getShopper()
    {
        return $this->shopper;
    }

    /**
     * @param Shopper $shopper
     */
    public function setShopper($shopper): void
    {
        $this->shopper = $shopper;
    }

    /**
     * @return Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param Shop $shop
     */
    public function setShop($shop): void
    {
        $this->shop = $shop;
    }
}
