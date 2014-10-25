<?php

namespace Zoop\Order\Test;

use \DateTime;

class TestDataCreator
{
    const STORE_NAME = 'teststore';
    const DIR = '/Assets/';

    public function createAll()
    {
        $store = $this->createStore();
        $this->createJson('Store', $store);

        $order = $this->createOrder();
        $this->createJson('Order', $order);
    }

    protected function createJson($fileName, $data)
    {
        file_put_contents(__DIR__ . self::DIR . $fileName . '.json', json_encode($data));
    }

    public function createStore()
    {
        $data = [
            'slug' => self::STORE_NAME,
            'name' => 'Test',
            'subdomain' => self::STORE_NAME,
            'email' => 'test@teststore.com'
        ];

        return $data;
    }

    public function createOrder()
    {
        $data = [
            'legacyId' => 1,
            'store' => self::STORE_NAME,
            'email' => 'testorder@order.com',
            'firstName' => 'Oscar',
            'lastName' => 'Le` Grouch',
            'address' => [
                'line1' => '1 Sesame Street',
                'line2' => null,
                'city' => 'Cartoon',
                'state' => 'VIC',
                'postcode' => '3000',
                'country' => 'AU',
            ],
            'phone' => null,
            'promotions' => [],
            'promotionRegistry' => [],
            'total' => [
                'shippingPrice' => 10,
                'productWholesalePrice' => 40,
                'productListPrice' => 100,
                'productQuantity' => 2,
                'discountPrice' => 10,
                'taxIncluded' => 9.09,
                'orderPrice' => 100,
                'currency' => [
                    'code' => 'AUD',
                    'name' => 'Australian Dollar',
                    'symbol' => '$',
                ]
            ],
            'items' => [
                [
                    'type' => 'SingleItem',
                    'legacyId' => 1,
                    'brand' => 'Garbarge',
                    'name' => 'Lid',
                    'imageSets' => [],
                    'price' => [
                        'unit' => [
                            'wholesale' => 20,
                            'list' => 50,
                            'sale' => 45,
                            'subTotal' => 45,
                            'productDiscount' => 5,
                            'cartDiscount' => 0,
                            'shippingDiscount' => 0,
                            'shipping' => 5,
                            'taxIncluded' => 4.09,
                        ],
                        'total' => [
                            'wholesale' => 40,
                            'list' => 100,
                            'sale' => 90,
                            'subTotal' => 90,
                            'productDiscount' => 10,
                            'cartDiscount' => 0,
                            'shippingDiscount' => 0,
                            'shipping' => 10,
                            'taxIncluded' => 8.18,
                        ]
                    ],
                    'sku' => [
                        'type' => 'PhysicalSku',
                        'legacyId' => 2,
                        'suppliers' => [],
//                        'inventory' => [],
                        'options' => [
                            [
                                'type' => 'Dropdown',
                                'label' => 'Size / Option',
                                'value' => 'Small',
                            ]
                        ],
                        'dimensions' => [
                            'weight' => 10,
                            'width' => 10,
                            'height' => 10,
                            'depth' => 1,
                        ]
                    ],
                    'state' => 'active',
                    'quantity' => 2,
                ]
            ],
            'shippingMethod' => null,
            'paymentMethod' => null,
            'state' => 'in-progress',
            'history' => [
                [
                    'state' => 'in-progress'
                ]
            ],
            'commission' => [
                'amount' => 0,
                'charged' => 0
            ],
            'coupon' => null,
            'invoiceSent' => false,
            'isWaitingForPayment' => false,
            'isComplete' => false,
            'invoiceSent' => false,
            'dateCompleted' => null,
            'hasProducts' => false,
        ];

        return $data;
    }
}
