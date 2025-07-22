<?php

return [
    'title' => 'PDF Report',
    'header' => [
        'report_category' => 'Report Category: :category',
        'period' => 'Period: :start_date to :end_date',
        'from' => 'From'
    ],
    'table' => [
        'no' => 'No',
        'columns' => [
            'order' => [
                'trash_name' => 'Trash Name',
                'type' => 'Type',
                'total_weight' => 'Total Weight'
            ],
            'withdraw' => [
                'bank' => 'Bank',
                'total_amount' => 'Total Withdraw'
            ]
        ],
        'footer' => [
            'order' => [
                'total_label' => 'Total Weight:',
                'total_value' => ':total'
            ],
            'withdraw' => [
                'total_label' => 'Total Withdraw:',
                'total_value' => 'Rp :total'
            ]
        ]
    ],
    'contact_info' => [
        'phone' => 'Phone: :phone',
        'email' => 'Email: :email'
    ]
];
