<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class that represents LolaMarket Products
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
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
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $price = '0.00';

    /**
     * Product is present in many order lines
     * @ORM\OneToMany(targetEntity="OrderLines", mappedBy="product")
     */
    private $orderLines;

    /**
     * A product can be found in many shops
     * @ORM\OneToMany(targetEntity="ProductsShops", mappedBy="product")
     */
    private $productsShops;

    /**
     * Product constructor.
     */
    public function __construct() {
        $this->orderLines = new ArrayCollection();
        $this->productsShops = new ArrayCollection();
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
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPrice(): string {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void {
        $this->price = $price;
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

    /**
     * @return mixed
     */
    public function getProductsShops() {
        return $this->productsShops;
    }

    /**
     * @param mixed $productShops
     */
    public function setProductsShops($productShops): void {
        $this->productsShops = $productShops;
    }
}
