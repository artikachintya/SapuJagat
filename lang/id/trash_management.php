<?php

return [
    'title' => 'Manajemen Sampah',
    'breadcrumb' => [
        'home' => 'Beranda',
        'dashboard' => 'Dashboard'
    ],
    'card' => [
        'title' => 'Rekapan Jenis Sampah Bulanan',
        'buttons' => [
            'create' => 'Buat Sampah',
            'archive' => 'Arsip Sampah'
        ]
    ],
    'table' => [
        'headers' => [
            'id' => 'ID',
            'image' => 'Gambar',
            'name' => 'Nama',
            'type' => 'Jenis',
            'price' => 'Harga',
            'max_weight' => 'Maksimal',
            'actions' => 'Aksi'
        ],
        'buttons' => [
            'update' => 'Perbaharui',
            'delete' => 'Hapus'
        ]
    ],
    'modals' => [
        'create' => [
            'title' => 'BUAT SAMPAH',
            'fields' => [
                'name' => 'Nama Sampah',
                'image' => 'Gambar Sampah',
                'type' => 'Jenis Sampah',
                'price' => 'Harga per kg',
                'max_weight' => 'Batas Maksimal'
            ],
            'submit' => 'BUAT SAMPAH'
        ],
        'edit' => [
            'title' => 'BUAT/UBAH SAMPAH',
            'submit' => 'UBAH SAMPAH'
        ],
        'delete' => [
            'title' => 'HAPUS DATA',
            'message' => 'Apakah Anda yakin ingin menghapus data ini?',
            'buttons' => [
            'cancel' => 'Batalkan',
                'confirm' => 'Konfirmasi'
            ]
        ],
        'uploadCSV' => 'Unggah File',
    ],
    'alerts' => [
        'success' => 'Operasi berhasil diselesaikan'
    ]
];
