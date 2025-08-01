<?php
return [
    'validation' => [
        'order_id' => [
            'required' => 'Order must be selected.',
            'exists' => 'Order not found.',
        ],
        'user_id' => [
            'required' => 'User must be selected.',
            'exists' => 'User not found.',
        ],
        'status' => [
            'in' => 'Status must be either 0 or 1.',
        ],
    ],
];
