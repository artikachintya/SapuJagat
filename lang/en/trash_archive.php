<?php

return [
    'title' => 'Deleted Data',
    'breadcrumb' => [
        'home' => 'Home',
        'current' => 'Deleted Trash'
    ],
    'page' => [
        'title' => 'Deleted Trash',
        'back_button' => 'Back'
    ],
    'table' => [
        'headers' => [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'price' => 'Price',
            'max_weight' => 'Maximum',
            'actions' => 'Actions'
        ],
        'empty' => 'No deleted data',
        'actions' => [
            'restore' => 'Restore',
            'force_delete' => 'Permanently Delete',
            'delete_confirm' => 'Are you sure to delete permanently?'
        ]
    ],
    'alerts' => [
        'success' => ':message'
    ]
];
