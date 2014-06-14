<?php

namespace Zoop\Order\Test\Controller;

use Zoop\Order\Test\AbstractTest;
use Zoop\Order\DataModel\Order;
use Zend\Session\Container;
use Zoop\Order\Test\Assets\TestData;
use Zoop\Order\DataModel\Item\SingleItem;

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
        $this->assertEquals('steve@apple.com', $order->getEmail());
        $this->assertEquals('Cupertino', $order->getAddress()->getCity());
        $this->assertEquals('US', $order->getAddress()->getCountry());
        $this->assertEquals(3, $order->getTotal()->getProductQuantity());
        $this->assertEquals(20, $order->getTotal()->getShippingPrice());
        $this->assertEquals(2295, $order->getTotal()->getProductListPrice());
        $this->assertEquals(1300, $order->getTotal()->getProductWholesalePrice());
        $this->assertEquals(2100, $order->getTotal()->getProductSubTotalPrice());
        $this->assertEquals(190.09, $order->getTotal()->getTaxIncluded());
        $this->assertEquals(2120, $order->getTotal()->getOrderPrice());
        
        $items = $order->getItems();
        $this->assertCount(2, $items);
        /* @var $item SingleItem */
        $item = $items[0];
        
        $this->assertEquals('11-inch MacBook Air', $item->getName());
        $this->assertEquals('Apple', $item->getBrand());
        $this->assertEquals(1099, $item->getPrice()->getTotal()->getList());
        $this->assertEquals(1000, $item->getPrice()->getTotal()->getSubTotal());
        $this->assertCount(1, $item->getSku()->getOptions());
        $this->assertEquals(1, $item->getQuantity());
    }
}
