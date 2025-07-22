<?php

return [
    'title' => 'Data Terhapus',
    'breadcrumb' => [
        'home' => 'Beranda',
        'current' => 'Penugasan Terhapus'
    ],
    'card' => [
        'title' => 'Penugasan yang Dihapus',
        'back_button' => 'Kembali'
    ],
    'table' => [
        'headers' => [
            'no' => 'No',
            'order_id' => 'Order ID',
            'user_name' => 'Nama Pengguna',
            'driver' => 'Driver',
            'actions' => 'Aksi'
        ],
        'empty' => 'Tidak ada data terhapus',
        'buttons' => [
            'restore' => 'Pulihkan',
            'permanent_delete' => 'Hapus Permanen'
        ]
    ],
    'alerts' => [
        'success' => 'Operasi berhasil diselesaikan',
        'delete_confirmation' => 'Yakin ingin menghapus permanen data ini?'
    ]
];
