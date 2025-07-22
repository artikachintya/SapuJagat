<?php

return [
    'title' => 'Tarik Saldo Pengguna',
    'breadcrumb' => [
        'home' => 'Beranda',
        'withdrawal' => 'Tarik Saldo'
    ],
    'balance_box' => [
        'title' => 'Saldo',
        'user_balance' => "Saldo :name"
    ],
    'form' => [
        'amount' => [
            'label' => 'Nominal Penarikan',
            'placeholder' => 'Rp Minimum 50.000',
            'info' => 'Dana dari penjualan sampah akan masuk ke rekening maksimal dalam 3 hari kerja.'
        ],
        'transfer_to' => [
            'label' => 'Transfer ke',
            'account_number' => 'Nomor Rekening:'
        ],
        'submit' => 'Tarik Dana'
    ],
    'modal' => [
        'title' => 'Edit Informasi Bank',
        'fields' => [
            'bank_name' => [
                'label' => 'Nama Bank',
                'placeholder' => 'BCA/BRI/MANDIRI'
            ],
            'account_number' => [
                'label' => 'Nomor Rekening',
                'placeholder' => 'Contoh: 1234567890'
            ]
        ],
        'buttons' => [
            'cancel' => 'Batal',
            'save' => 'Simpan'
        ]
    ],
    'validation' => [
        'min_amount' => 'Minimal penarikan adalah Rp50.000'
    ]
];
