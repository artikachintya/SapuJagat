<?php

return [
    'title' => 'Laporan PDF',
    'header' => [
        'report_category' => 'Laporan Kategori: :category',
        'period' => 'Periode: :start_date s/d :end_date',
        'from' => 'Dari'
    ],
    'table' => [
        'no' => 'No',
        'columns' => [
            'order' => [
                'trash_name' => 'Nama Sampah',
                'type' => 'Type',
                'total_weight' => 'Total Berat'
            ],
            'withdraw' => [
                'bank' => 'Bank',
                'total_amount' => 'Total Penarikan'
            ]
        ],
        'footer' => [
            'order' => [
                'total_label' => 'Total Berat:',
                'total_value' => ':total'
            ],
            'withdraw' => [
                'total_label' => 'Total Penarikan:',
                'total_value' => 'Rp :total'
            ]
        ]
    ],
    'contact_info' => [
        'phone' => 'No HP: :phone',
        'email' => 'Email: :email'
    ]
];
