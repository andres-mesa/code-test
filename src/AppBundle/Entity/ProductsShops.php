<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsShops
 *
 * @ORM\Table(name="products_shops")
 * @ORM\Entity
 */
class ProductsShops
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
     * Many Products are avariable in a shop
     * @var \AppBundle\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productsShops")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     */
    private $product;

    /**
     * Many shops has common products
     * @var \AppBundle\Entity\Shop
     *
     * @ORM\ManyToOne(targetEntity="Shop", inversedBy="productsShops")
     * @ORM\JoinColumn(name="shopId", referencedColumnName="id")
     */
    private $shop;

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
     * @return Product
     */
    public function getProduct(): Product {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void {
        $this->product = $product;
    }

    /**
     * @return Shop
     */
    public function getShop(): Shop {
        return $this->shop;
    }

    /**
     * @param Shop $shop
     */
    public function setShop(Shop $shop): void {
        $this->shop = $shop;
    }
}
