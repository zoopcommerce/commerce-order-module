<?php

namespace Zoop\Order\Test\Assets;

use Zoop\Shard\Serializer\Unserializer;
use Zoop\Store\DataModel\Store;
use Zoop\Order\DataModel\Order;

class TestData
{
    const DOCUMENT_ORDER = 'Zoop\Order\DataModel\Order';
    const DOCUMENT_STORE = 'Zoop\Store\DataModel\Store';
    
    /**
     * @param Unserializer $unserializer
     * @return Store
     */
    public static function createStore(Unserializer $unserializer)
    {
        $data = self::getJson('Store');
        return $unserializer->fromJson($data, self::DOCUMENT_STORE);
    }
    
    /**
     * @param Unserializer $unserializer
     * @return Order
     */
    public static function createOrder(Unserializer $unserializer)
    {
        $data = self::getJson('Order');
        return $unserializer->fromJson($data, self::DOCUMENT_ORDER);
    }

    protected static function getJson($fileName)
    {
        return file_get_contents(__DIR__ . '/' . $fileName . '.json');
    }
}
