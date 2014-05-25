<?php

namespace Zoop\Order\Test\Controller;

use Zoop\Order\Test\BaseTest;
use Zoop\Order\DataModel\Order;
use Zoop\Store\DataModel\Store;
use Zend\Session\Container;

class OrderTest extends BaseTest
{
    protected $store;

    /**
     * @runInSeparateProcess
     */
    public function testEmptyActiveOrderManager()
    {
        $order = $this->getApplicationServiceLocator()->get('zoop.commerce.order.active');

        /* @var $order Order */
        $this->assertInstanceOf('Zoop\Order\DataModel\Order', $order);
        $this->assertEmpty($order->getId());
    }

    /**
     * @runInSeparateProcess
     */
    public function testActiveOrderManager()
    {
        $this->createOrder();

        $order = $this->getApplicationServiceLocator()->get('zoop.commerce.order.active');

        /* @var $order Order */
        $this->assertInstanceOf('Zoop\Order\DataModel\Order', $order);
        $this->assertNotEmpty($order->getId());
        $this->assertEquals('test@email.com', $order->getEmail());
    }

    protected function createOrder()
    {
        $order = new Order;
        $order->setEmail('test@email.com');
        $order->setState('in-progress');
        $order->setStore($this->getStore());

        $this->getDocumentManager()->persist($order);
        $this->getDocumentManager()->flush($order);

        $sessionContainer = $this->getApplicationServiceLocator()->get('zoop.commerce.common.session.container.order');
        /* @var $sessionContainer Container */
        $sessionContainer->id = $order->getId();

        $this->getDocumentManager()->clear($order);
    }

    protected function getStore()
    {
        if (!isset($this->store)) {
            $store = new Store;
            $store->setName('Demo');
            $store->setSlug('demo');
            $store->setSubdomain('demo.zoopcommerce.local');
            $store->setEmail('demo@demo.com');

            $this->getDocumentManager()->persist($store);
            $this->getDocumentManager()->flush($store);
            $this->getDocumentManager()->clear($store);

            $this->store = $store;
        }

        return $this->store;
    }
}
