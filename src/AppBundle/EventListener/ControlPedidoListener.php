<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\LineasPedido;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class ControlPedidoListener
 * @package AppBundle\EventListener
 */
class ControlPedidoListener
{
    /**
     * Evento para actualizar el valor de un pedido tras una inserción en LineasPedido
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof LineasPedido) {
            $pedido = $entity->getPedido();
            $producto = $entity->getProducto();
            $unidades = $entity->getUnidades();

            $incrementoPrecio = $producto->getPrecio() * $unidades;
            $pedido->setImporteTotal($pedido->getImporteTotal() + $incrementoPrecio);
            $em = $args->getEntityManager();
            $em->persist($pedido);
            $em->flush();

        }
    }

    /**
     * Evento para actualizar el valor total del pedido al borrar una linea en LineasPedido
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof LineasPedido) {
            $pedido = $entity->getPedido();
            $producto = $entity->getProducto();
            $unidades = $entity->getUnidades();

            $decrementoPrecio = $producto->getPrecio() * $unidades;
            $pedido->setImporteTotal($pedido->getImporteTotal() - $decrementoPrecio);
            $em = $args->getEntityManager();
            $em->persist($pedido);
            $em->flush();
        }
    }
}