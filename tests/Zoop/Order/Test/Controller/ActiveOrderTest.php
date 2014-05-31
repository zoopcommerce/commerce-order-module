<?php

namespace Zoop\Order\Test\Controller;

use Zoop\Order\Test\AbstractTest;
use Zoop\Order\DataModel\Order;
use Zend\Session\Container;
use Zoop\Order\Test\Assets\TestData;

class OrderTest extends AbstractTest
{
    protected static $store;

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
        $order = TestData::createOrder(self::getUnserializer());
        $this->getDocumentManager()->persist($order);
        $this->getDocumentManager()->flush($order);
        
        $sessionContainer = $this->getApplicationServiceLocator()
            ->get('zoop.commerce.common.session.container.order');
        
        /* @var $sessionContainer Container */
        $sessionContainer->id = $order->getId();

        $this->getDocumentManager()->clear($order);

        $order = $this->getApplicationServiceLocator()->get('zoop.commerce.order.active');

        /* @var $order Order */
        $this->assertInstanceOf('Zoop\Order\DataModel\Order', $order);
        $this->assertNotEmpty($order->getId());
        $this->assertEquals('testorder@order.com', $order->getEmail());
    }
}
