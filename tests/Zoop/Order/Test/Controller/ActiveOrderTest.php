<?php

namespace Zoop\Order\Test\Controller;

use Zend\Session\Container;
use Zoop\Order\Test\AbstractTest;
use Zoop\Order\DataModel\Order;
use Zoop\Order\DataModel\Item\ItemInterface;
use Zoop\Product\DataModel\DimensionsInterface;
use Zoop\Order\DataModel\Item\PhysicalSkuInterface;
use Zoop\Order\Test\Assets\TestData;
use Zoop\Test\Helper\DataHelper;

class ActiveOrderTest extends AbstractTest
{
    private static $testDataCreated = false;

    public function setUp()
    {
        parent::setUp();

        if (self::$testDataCreated === false) {
            DataHelper::createZoopUser(self::getNoAuthDocumentManager(), self::getDbName());
            DataHelper::createStores(self::getNoAuthDocumentManager(), self::getDbName());

            //mock active store
            $this->getApplicationServiceLocator()->setAllowOverride(true);
            $this->getApplicationServiceLocator()->setService('zoop.commerce.store.active', $this->getStore());
            self::$testDataCreated = true;
        }
    }

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

        $this->getDocumentManager()->detach($order);

        $order = $this->getApplicationServiceLocator()->get('zoop.commerce.order.active');

        $this->assertTrue($order instanceof Order);
        $this->assertNotEmpty($order->getId());
        $this->assertEquals('apple', $order->getStore());
        $this->assertEquals('steve@apple.com', $order->getEmail());
        $this->assertEquals('Cupertino', $order->getCustomerAddress()->getCity());
        $this->assertEquals('US', $order->getCustomerAddress()->getCountry());
        $this->assertEquals('Cartoon', $order->getShippingAddress()->getCity());
        $this->assertEquals('AU', $order->getShippingAddress()->getCountry());
        $this->assertEquals(3, $order->getTotal()->getProductQuantity());
        $this->assertEquals(20, $order->getTotal()->getShippingPrice());
        $this->assertEquals(2295, $order->getTotal()->getProductListPrice());
        $this->assertEquals(1300, $order->getTotal()->getProductWholesalePrice());
        $this->assertEquals(2100, $order->getTotal()->getProductSubTotalPrice());
        $this->assertEquals(190.09, $order->getTotal()->getTaxIncluded());
        $this->assertEquals(2120, $order->getTotal()->getOrderPrice());

        $items = $order->getItems();
        $this->assertCount(2, $items);

        //item 1
        $item = $items[0];

        $this->assertTrue($item instanceof ItemInterface);
        $this->assertEquals('11-inch MacBook Air', $item->getName());
        $this->assertEquals('Apple', $item->getBrand());
        $this->assertEquals(1099, $item->getPriceSet()->getTotal()->getList());
        $this->assertEquals(1000, $item->getPriceSet()->getTotal()->getSubTotal());
        $this->assertEquals(1, $item->getQuantity());

        $sku = $item->getSku();
        $this->assertTrue($sku instanceof PhysicalSkuInterface);
        $this->assertCount(1, $sku->getOptions());

        $dimensions = $sku->getDimensions();
        $this->assertTrue($dimensions instanceof DimensionsInterface);
        $this->assertEquals(5, $dimensions->getWeight());
        $this->assertEquals(25, $dimensions->getWidth());
        $this->assertEquals(25, $dimensions->getHeight());
        $this->assertEquals(10, $dimensions->getDepth());

        //item 2
        $item = $items[1];

        $this->assertTrue($item instanceof ItemInterface);
        $this->assertEquals('iPad Air', $item->getName());
        $this->assertEquals('Apple', $item->getBrand());
        $this->assertEquals(1196, $item->getPriceSet()->getTotal()->getList());
        $this->assertEquals(1100, $item->getPriceSet()->getTotal()->getSubTotal());
        $this->assertEquals(2, $item->getQuantity());

        $sku = $item->getSku();
        $this->assertTrue($sku instanceof PhysicalSkuInterface);
        $this->assertCount(3, $sku->getOptions());

        $dimensions = $sku->getDimensions();
        $this->assertTrue($dimensions instanceof DimensionsInterface);
        $this->assertEquals(2, $dimensions->getWeight());
        $this->assertEquals(10, $dimensions->getWidth());
        $this->assertEquals(10, $dimensions->getHeight());
        $this->assertEquals(5, $dimensions->getDepth());
    }
}
