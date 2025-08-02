<?php

return [
    'title' => 'Pickup Detail',
    'customer' => [
        'default_name' => 'Customer Name',
        'default_address' => 'No address',
        'default_city' => 'City',
        'default_province' => 'Province',
        'default_postal' => 'Postal code'
    ],
    'elements' => [
        'chat_button' => 'Open Chat',
        'photo_evidence' => 'Photo Evidence',
        'upload_section' => [
            'title' => 'Upload Delivery Evidence',
            'preview' => 'Preview'
        ],
        'delivery_notes' => 'Delivery Notes',

    ],
    'buttons' => [
        'start_pickup' => 'Start Pickup',
        'waste_picked' => 'Waste Picked Up',
        'complete_pickup' => 'Pickup Completed'
    ],
    'success_popup' => [
        'title' => '🎉 Yay! You have completed the order!',
        'message' => 'Thank you for picking up the customer\'s waste.<br>You will be redirected to the pickup list in 5 seconds...'
    ],
    'validation' => [
        'photo_required' => 'Photo evidence is required'
    ]
];
