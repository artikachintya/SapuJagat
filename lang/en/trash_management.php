<?php

return [
    'title' => 'Trash Management',
    'breadcrumb' => [
        'home' => 'Home',
        'dashboard' => 'Dashboard'
    ],
    'card' => [
        'title' => 'Monthly Trash Type Summary',
        'buttons' => [
            'create' => 'Create Trash',
            'archive' => 'View Archive'
        ]
    ],
    'table' => [
        'headers' => [
            'id' => 'ID',
            'image' => 'Image',
            'name' => 'Name',
            'type' => 'Type',
            'price' => 'Price',
            'max_weight' => 'Max Weight',
            'actions' => 'Actions'
        ],
        'buttons' => [
            'update' => 'Update',
            'delete' => 'Delete'
        ]
    ],
    'modals' => [
        'create' => [
            'title' => 'CREATE TRASH',
            'fields' => [
                'name' => 'Trash Name',
                'image' => 'Trash Image',
                'type' => 'Trash Type',
                'price' => 'Price per kg',
                'max_weight' => 'Weight Limit'
            ],
            'submit' => 'CREATE TRASH'
        ],
        'edit' => [
            'title' => 'CREATE/EDIT TRASH',
            'submit' => 'UPDATE TRASH'
        ],
        'delete' => [
            'title' => 'DELETE DATA',
            'message' => 'Are you sure you want to delete this data?',
            'buttons' => [
                'cancel' => 'Cancel',
                'confirm' => 'Confirm'
            ]
        ]
    ],
    'alerts' => [
        'success' => 'Operation completed successfully'
    ]
];
