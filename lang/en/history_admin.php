<?php

return [
    'title' => 'User Exchange History',
    'table' => [
        'columns' => [
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'trash_type' => 'Trash Type',
            'quantity' => 'Quantity',
            'cost' => 'Price',
            'completion_date' => 'Completion Date',
            'approval_date' => 'Approval Date',
            'action' => 'Action'
        ],
        'statuses' => [
            'completed' => 'Completed',
            'rejected' => 'Rejected',
            'in_process' => 'In Process',
            'no_approval' => 'No Approval Yet'
        ],
        'buttons' => [
            'details' => 'Details'
        ]
    ],
    'modal' => [
        'title' => 'Order Details ',
        'fields' => [
            'user_id' => 'User ID',
            'customer_name' => 'Customer Name',
            'request_datetime' => 'Request Date/Time',
            'pickup_datetime' => 'Pickup Date/Time',
            'completion_datetime' => 'Completion Date/Time',
            'inspection_date' => 'Inspection Date',
            'status' => 'Status',
            'user_proof' => 'User Proof',
            'driver_proof' => 'Driver Proof',
            'admin_response' => 'Admin Response',
            'driver_notes' => 'Driver Notes'
        ],
        'no_photo' => 'No photo available',
        'summary' => [
            'headers' => [
                'no' => 'No',
                'trash_name' => 'Trash Name',
                'quantity' => 'Quantity',
                'price_per_kg' => 'Price/kg',
                'total' => 'Total'
            ],
            'total_earned' => 'Total Earned'
        ]
    ]
];
