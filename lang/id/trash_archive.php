<?php

return [
    'title' => 'Data Terhapus',
    'breadcrumb' => [
        'home' => 'Home',
        'current' => 'Sampah Terhapus'
    ],
    'page' => [
        'title' => 'Sampah yang Dihapus',
        'back_button' => 'Kembali'
    ],
    'table' => [
        'headers' => [
            'id' => 'ID',
            'name' => 'Nama',
            'type' => 'Jenis',
            'price' => 'Harga',
            'max_weight' => 'Maksimal',
            'actions' => 'Aksi'
        ],
        'empty' => 'Tidak ada data terhapus',
        'actions' => [
            'restore' => 'Pulihkan',
            'force_delete' => 'Hapus Permanen',
            'delete_confirm' => 'Yakin hapus permanen?'
        ]
    ],
    'alerts' => [
        'success' => ':message'
    ]
];
