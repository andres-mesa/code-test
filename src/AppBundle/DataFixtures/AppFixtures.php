<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\OrderLines;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use AppBundle\Entity\Shopper;
use AppBundle\Entity\Shop;
use AppBundle\Entity\ProductsShops;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package AppBundle\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * Inyected variable to encode the user and shopper password (same algorithm)
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        //20 customers and their addresses
        for ($i = 0; $i < 20; $i++) {
            $customer = new Customer();
            $customer->setName("Name ".$i);
            $customer->setSurname1("Surname ".$i);
            $customer->setSurname2("Surname ".$i);
            $customer->setEmail("customer".$i."@lolamarket.com");
            $customer->setRoles(array('ROLE_USER'));
            $password = $this->encoder->encodePassword($customer, 'lolamarket'); //Same password for all for test purposes
            $customer->setPassword($password);


            $address = new Address();
            $address->setCustomer($customer);
            $address->setStreet("Street ". $i);
            $address->setZipCode(strval(28000 + $i));
            $address->setCity("City ". $i);

            $manager->persist($customer);
            $manager->persist($address);
            $manager->flush();
        }

        //20 Shoppers
        for ($i = 0; $i < 20; $i++) {
            $shopper = new Shopper();
            $shopper->setName("Name ".$i);
            $shopper->setEmail("shopper".$i."@lolamarket.com");
            $shopper->setRoles(array('ROLE_USER'));
            $password = $this->encoder->encodePassword($shopper, 'lolamarket');
            $shopper->setPassword($password);
            $manager->persist($shopper);
        }

        //5 Shops
        for ($i = 0; $i < 5; $i++) {
            $shop = new Shop();
            $shop->setName("Name ".$i);
            $shop->setShopAddress("Address ".$i);
            $manager->persist($shop);
        }

        $manager->flush();

        //50 products and relations with some shops
        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setName("Product " . $i);
            $product->setDescription("Description ".$i);
            $product->setPrice(mt_rand (0*10, 50*10) / 10);
            $manager->persist($product);
            $manager->flush();

            //Select some shops
            $shops =  $manager->getRepository(Shop::class)->findAll();
            $randomShops = array_rand($shops, rand(1,count($shops)));

            //Relate with some products
            if(is_array($randomShops)){
                foreach ($randomShops as $shop){
                    $productsShops = new ProductsShops();
                    $productsShops->setProduct($product);
                    $productsShops->setShop($shops[$shop]);
                    $manager->persist($productsShops);
                    $manager->flush();
                }
            }else{
                $productsShops = new ProductsShops();
                $productsShops->setProduct($product);
                $productsShops->setShop($shops[$randomShops]);
                $manager->persist($productsShops);
                $manager->flush();
            }
        }

        //10 Orders
        for ($i = 0; $i < 10; $i++) {

            $order = new Order();
            $order->setPhone(strval(918493100 + $i));

            //Order date & Delivery Date
            $today = new \DateTime('now');
            $order->setOrderDate($today);
            $order->setDeliveryDate($today->add(new \DateInterval('P1D')));
            $order->setOrigin("iOS");

            //Random user
            $customers =  $manager->getRepository(Customer::class)->findAll();
            $randomCustomer = array_rand($customers, 1);
            $order->setCustomer($customers[$randomCustomer]);

            //Random address from the user
            $addresses = $manager->getRepository(Address::class)->findBy(array("customer"=>$order->getCustomer()->getId()));
            $randomAddress = array_rand($addresses, 1);
            $order->setAddress($addresses[$randomAddress]);

            //Full name, email and full address
            $customer = $order->getCustomer();
            $fullName = $customer->getName(). " " .$customer->getSurname1(). " " .$customer->getSurname2();
            $order->setFullName($fullName);

            $email = $order->getCustomer()->getEmail();
            $order->setEmail($email);

            $deliveryAddress = $order->getAddress()->getStreet() . " " . $order->getAddress()->getCity() . " " . $order->getAddress()->getZipCode();
            $order->setDeliveryAddress($deliveryAddress);

            $order->setDeliverySlotId(rand(0,10));
            $order->setTotal(0.0);

            $manager->persist($order);
            $manager->flush();

            //Add shome random order lines
            $shops =  $manager->getRepository(Shop::class)->findAll();
            $randomShops = array_rand($shops, rand(2,count($shops)));

            foreach ($randomShops as $randomShop){
                $shop = $shops[$randomShop];
                $avariableProductsInShop = $manager->getRepository(ProductsShops::class)->findBy(array("shop"=>$shop));
                $shomeRandomProducts = array_rand($avariableProductsInShop, rand(2,count($avariableProductsInShop)));

                foreach ($shomeRandomProducts as $shopProduct){
                    $orderLine = new OrderLines();
                    $orderLine->setOrder($order);
                    $orderLine->setShop($shop);
                    $orderLine->setUnits(rand(1,10));
                    $orderLine->setProduct($avariableProductsInShop[$shopProduct]->getProduct());
                    $manager->persist($orderLine);
                    $manager->flush();
                }
            }
        }

        //Link the shoppers with some products
        $shops  =  $manager->getRepository(Shop::class)->findAll();
        $shoppers =  $manager->getRepository(Shopper::class)->findAll();

        //Get random shop, search some lines y link the shopper if it's not
        foreach ($shoppers as $shopper){
            $randomShop = array_rand($shops, 1);
            $orderLinesWithoutShopper = $manager->getRepository(OrderLines::class)->findBy(array("shop"=>$shops[$randomShop], "shopper"=> null));

            foreach ($orderLinesWithoutShopper as $orderLine){
                $orderLine->setShopper($shopper);
                $manager->persist($orderLine);
            }
            $manager->flush();
        }

        //From all the shops, empty the shopper at least in one case to easy testing the dispatch endpoint
        foreach ($shops as $shop){
            $productLine = $manager->getRepository(OrderLines::class)->findBy(array("shop"=>$shop));
            foreach ($productLine as $line){
                $line->setShopper(null);
                $manager->persist($line);
                $manager->flush();
                break;
            }
        }
    }
}