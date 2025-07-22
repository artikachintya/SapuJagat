<?php

return [
    'title' => 'Deleted Assignments',
    'breadcrumb' => [
        'home' => 'Home',
        'current' => 'Deleted Assignments'
    ],
    'card' => [
        'title' => 'Deleted Assignments',
        'back_button' => 'Back'
    ],
    'table' => [
        'headers' => [
            'no' => 'No',
            'order_id' => 'Order ID',
            'user_name' => 'User Name',
            'driver' => 'Driver',
            'actions' => 'Actions'
        ],
        'empty' => 'No deleted data available',
        'buttons' => [
            'restore' => 'Restore',
            'permanent_delete' => 'Permanently Delete'
        ]
    ],
    'alerts' => [
        'success' => 'Operation completed successfully',
        'delete_confirmation' => 'Are you sure you want to permanently delete this data?'
    ]
];
