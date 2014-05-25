<?php

namespace Zoop\Order\Service;

use Zoop\Order\DataModel\Order;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;

class ActiveOrderFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return Order
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sessionContainer = $serviceLocator->get('zoop.commerce.common.session.container.order');

        /* @var $sessionContainer Container */
        if(isset($sessionContainer->id)) {
            $order = $this->loadOrder($sessionContainer->id, $serviceLocator);
        }
        
        if(empty($order)) {
            $order = new Order;
        }
        
        return $order;
    }

    /**
     * @param string $id
     * @param ServiceLocatorInterface $serviceLocator
     * @return Order|null
     */
    protected function loadOrder($id, ServiceLocatorInterface $serviceLocator)
    {
        $documentManager = $serviceLocator->get('shard.commerce.modelmanager');

        $order = $documentManager
            ->createQueryBuilder()
            ->find('Zoop\Order\DataModel\Order')
            ->field('id')->equals($id)
            ->getQuery()
            ->getSingleResult();

        return $order;
    }
}
