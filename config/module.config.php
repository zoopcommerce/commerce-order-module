<?php

return [
    'zoop' => [
        'shard' => [
            'manifest' => [
                'commerce' => [
                    'models' => [
                        'Zoop\Order\DataModel' => __DIR__ . '/../src/Zoop/Order/DataModel',
                    ]
                ]
            ]
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
        ],
        'factories' => [
            //services
            'zoop.commerce.order.active' => 'Zoop\Order\Service\ActiveOrderFactory',
        ],
    ],
];
