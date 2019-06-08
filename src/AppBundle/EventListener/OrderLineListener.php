<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\OrderLines;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class OrderLineListener
 * @package AppBundle\EventListener
 */
class OrderLineListener
{
    /**
     * Lifecycle event triggered after persist, controls order total price
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof OrderLines) {
            $order = $entity->getOrder();
            $product = $entity->getProduct();
            $units = $entity->getUnits();

            $addedPrice = $product->getPrice() * $units;
            $order->setTotal($order->getTotal() + $addedPrice);
            $em = $args->getEntityManager();
            $em->persist($order);
            $em->flush();

        }
    }

    /**
     * Lifecycle event triggered before remove an order line, controls order total price
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof OrderLines) {
            $order = $entity->getOrder();
            $product = $entity->getProduct();
            $units = $entity->getUnits();

            $addedPrice = $product->getPrice() * $units;
            $order->setTotal($order->getTotal() - $addedPrice);
            $em = $args->getEntityManager();
            $em->persist($order);
            $em->flush();

        }
    }
}