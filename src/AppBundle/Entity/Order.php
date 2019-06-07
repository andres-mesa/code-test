<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class that represents a customer order
 *
 * @ORM\Table(name="`order`")
 * @ORM\Entity
 */
class Order
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
     * Many orders has a client
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="id")
     */
    private $customer;

    /**
     * Many orders has an address
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="orders")
     * @ORM\JoinColumn(name="addressId", referencedColumnName="id")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer", nullable=false)
     */
    private $phone = '000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="deliveryAddress", type="string", length=255, nullable=true)
     */
    private $deliveryAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="datetime", nullable=true)
     */
    private $orderDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deliveryDate", type="date", nullable=true)
     */
    private $deliveryDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="deliverySlotId", type="integer", nullable=true)
     */
    private $deliverySlotId;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * An Order has many Order Lines
     * @ORM\OneToMany(targetEntity="OrderLines", mappedBy="order")
     */
    private $orderLines;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    }

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
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone(int $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getDeliveryAddress(): string
    {
        return $this->deliveryAddress;
    }

    /**
     * @param string $deliveryAddress
     */
    public function setDeliveryAddress(string $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }

    /**
     * @param \DateTime $orderDate
     */
    public function setOrderDate(\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return \DateTime
     */
    public function getDeliveryDate(): \DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * @param \DateTime $deliveryDate
     */
    public function setDeliveryDate(\DateTime $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return int
     */
    public function getDeliverySlotId(): int
    {
        return $this->deliverySlotId;
    }

    /**
     * @param int $deliverySlotId
     */
    public function setDeliverySlotId(int $deliverySlotId): void
    {
        $this->deliverySlotId = $deliverySlotId;
    }

    /**
     * @return string
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * @param string $total
     */
    public function setTotal(string $total): void
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     */
    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }

    /**
     * @return mixed
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * @param mixed $orderLines
     */
    public function setOrderLines($orderLines): void
    {
        $this->orderLines = $orderLines;
    }
}
