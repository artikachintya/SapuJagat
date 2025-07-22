<?php

return [
    'title' => 'Ringkasan Pesanan',
    'table' => [
        'headers' => [
            'trash_name' => 'Nama Sampah',
            'quantity' => 'Kuantitas',
            'price' => 'Harga / Kg',
            'total' => 'Estimasi Total'
        ],
    ],
    'total' => 'Estimasi Total yang Diperoleh = ',
    'form' => [
        'pickup_time' => [
            'label' => 'Pilih Waktu Penjemputan',
            'placeholder' => '-- Pilih Waktu --',
        ],
        'photo' => [
            'label' => 'Unggah Bukti Pesanan',
            'placeholder' => 'Pilih File'
        ],
        'buttons' => [
            'back' => 'Kembali',
            'confirm' => 'Jemput'
        ]
    ],
    'modal' => [
        'title' => 'Konfirmasi Pesanan',
        'body' => 'Apakah kamu yakin untuk memesan layanan penjemputan ini?',
        'buttons' => [
            'cancel' => 'Tidak',
            'confirm' => 'Iya'
        ]
    ]
];
