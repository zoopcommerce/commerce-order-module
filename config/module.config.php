<?php

return [
    'service_manager' => [
        'abstract_factories' => [
        ],
        'factories' => [
            //services
            'zoop.commerce.order.active' => 'Zoop\Order\Service\ActiveOrderFactory',
        ],
    ],
];
