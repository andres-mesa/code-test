<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\LineasPedido;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ControlPedidoListener
{
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