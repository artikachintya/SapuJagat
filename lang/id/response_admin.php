<?php

return [
    'title' => 'Respon Laporan',
    'page_title' => 'Daftar Laporan dari Pengguna',
    'table_title' => 'Tabel Laporan Pengguna',

    'table' => [
        'headers' => [
            'id' => 'ID',
            'user_id' => 'ID User',
            'reporter_name' => 'Nama Pelapor',
            'report_content' => 'Isi Laporan',
            'report_date' => 'Tanggal Laporan',
            'response_date' => 'Tanggal Direspon',
            'status' => 'Status',
            'actions' => 'Aksi'
        ],
        'status' => [
            'responded' => 'Sudah Direspon',
            'pending' => 'Belum Direspon'
        ],
        'action_button' => 'Detail'
    ],

    'modal' => [
        'title' => 'Detail Laporan #:id',
        'fields' => [
            'user_id' => 'ID User',
            'reporter_name' => 'Nama Pelapor',
            'report_content' => 'Isi Laporan',
            'report_date' => 'Tanggal Laporan',
            'response_date' => 'Tanggal Direspon',
            'status' => 'Status',
            'photo' => 'Foto Bukti',
            'response_content' => 'Isi Respon',
            'admin' => 'Admin'
        ],
        'response_form' => [
            'label' => 'Tulis Respon Admin:',
            'submit' => 'Kirim Respon'
        ],
        'close_button' => 'Tutup'
    ],

    'alerts' => [
        'success' => ':message'
    ]
];
