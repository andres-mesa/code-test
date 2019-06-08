<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents an available Shop to buy products
 *
 * @ORM\Table(name="shop")
 * @ORM\Entity
 */
class Shop
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shopAddress", type="string", length=255, nullable=true)
     */
    private $shopAddress;


    /**
     * A shop has many products related
     * @ORM\OneToMany(targetEntity="ProductsShops", mappedBy="shop")
     */
    private $productsShops;

    /**
     * A shop has many product lines
     * @ORM\OneToMany(targetEntity="OrderLines", mappedBy="shop")
     */
    private $orderLines;

    /**
     * Shop constructor
     */
    public function __construct() {
        $this->productsShops = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getShopAddress(): string {
        return $this->shopAddress;
    }

    /**
     * @param string $shopAddress
     */
    public function setShopAddress(string $shopAddress): void {
        $this->shopAddress = $shopAddress;
    }

    /**
     * @return ArrayCollection<ProductsShops>
     */
    public function getProductsShops() {
        return $this->productsShops;
    }

    /**
     * @param ArrayCollection<ProductsShops> $productsShops
     */
    public function setProductsShops($productsShops): void {
        $this->productsShops = $productsShops;
    }

    /**
     * @return ArrayCollection<OrderLines>
     */
    public function getOrderLines() {
        return $this->orderLines;
    }

    /**
     * @param ArrayCollection<OrderLines> $orderLines
     */
    public function setOrderLines($orderLines): void {
        $this->orderLines = $orderLines;
    }
}
