<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Customer/User of LolaMarket
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity
 */
class Customer implements UserInterface
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
     * @ORM\Column(name="surname1", type="string", length=255, nullable=true)
     */
    private $surname1;

    /**
     * @var string
     *
     * @ORM\Column(name="surname2", type="string", length=255, nullable=true)
     */
    private $surname2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * A customer has many orders
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer")
     */
    private $orders;

    /**
     * A customer has many addresses
     * @ORM\OneToMany(targetEntity="Address", mappedBy="customer")
     */
    private $addresses;


    /**
     * Constructor de clase
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->addresses = new ArrayCollection();
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname1(): string
    {
        return $this->surname1;
    }

    /**
     * @param string $surname1
     */
    public function setSurname1(string $surname1): void
    {
        $this->surname1 = $surname1;
    }

    /**
     * @return string
     */
    public function getSurname2(): string
    {
        return $this->surname2;
    }

    /**
     * @param string $surname2
     */
    public function setSurname2(string $surname2): void
    {
        $this->surname2 = $surname2;
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
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return mixed
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param mixed $addresses
     */
    public function setAddresses($addresses): void
    {
        $this->addresses = $addresses;
    }

    /**
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;


        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(){}

    /**
     * @see UserInterface
     */
    public function eraseCredentials(){}
}
