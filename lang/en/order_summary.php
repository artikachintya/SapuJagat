<?php

return [
    'title' => 'Order Summary',
    'table' => [
        'headers' => [
            'trash_name' => 'Trash Name',
            'quantity' => 'Quantity',
            'price' => 'Price / Kg',
            'total' => 'Estimated Total'
        ],
    ],
    'total' => 'Estimated Total Earned = ',
    'form' => [
        'pickup_time' => [
            'label' => 'Select Pickup Time',
            'placeholder' => '-- Select Time --',
        ],
        'photo' => [
            'label' => 'Upload Order Proof',
            'placeholder' => 'Choose File'
        ],
        'buttons' => [
            'back' => 'Back',
            'confirm' => 'Pickup'
        ]
    ],
    'modal' => [
        'title' => 'Order Confirmation',
        'body' => 'Are you sure you want to order this pickup service?',
        'buttons' => [
            'cancel' => 'No',
            'confirm' => 'Yes'
        ]
    ]
];
