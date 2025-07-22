<?php

return [
    'title' => 'Histori Penukaran Pengguna',
    'table' => [
        'columns' => [
            'order_id' => 'ID Order',
            'user_id' => 'ID User',
            'trash_type' => 'Jenis Sampah',
            'quantity' => 'Kuantiti',
            'cost' => 'Harga',
            'completion_date' => 'Tanggal Selesai',
            'approval_date' => 'Tanggal Disetujui',
            'action' => 'Aksi'
        ],
        'statuses' => [
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            'in_process' => 'Dalam Proses',
            'no_approval' => 'Belum Ada Persetujuan'
        ],
        'buttons' => [
            'details' => 'Detail'
        ]
    ],
    'modal' => [
        'title' => 'Detail Order ',
        'fields' => [
            'user_id' => 'ID User',
            'customer_name' => 'Nama Pelanggan',
            'request_datetime' => 'Tanggal/Waktu Permintaan',
            'pickup_datetime' => 'Tanggal/Waktu Penjemputan',
            'completion_datetime' => 'Tanggal/Waktu Selesai Penjemputan',
            'inspection_date' => 'Tanggal Pengecekan',
            'status' => 'Status',
            'user_proof' => 'Bukti Pengguna',
            'driver_proof' => 'Bukti Pengantaran Driver',
            'admin_response' => 'Respon Admin',
            'driver_notes' => 'Catatan Driver'
        ],
        'no_photo' => 'Tidak ada foto',
        'summary' => [
            'headers' => [
                'no' => 'No',
                'trash_name' => 'Nama Sampah',
                'quantity' => 'Kuantitas',
                'price_per_kg' => 'Harga/kg',
                'total' => 'Total'
            ],
            'total_earned' => 'Total yang Diperoleh'
        ]
    ]
];
