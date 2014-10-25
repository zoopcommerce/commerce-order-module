<?php

namespace Zoop\Order\Test\Assets;

use Zoop\Shard\Serializer\Unserializer;
use Zoop\Order\DataModel\Order;

class TestData
{
    const DOCUMENT_ORDER = 'Zoop\Order\DataModel\Order';

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
