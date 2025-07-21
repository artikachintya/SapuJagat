<?php

return [
    'title' => 'Dashboard',
    'welcome' => 'Selamat datang, ',
    'breadcrumb' => [
        'home' => 'Beranda',
        'dashboard' => 'Dashboard'
    ],
    'cards' => [
        'today_transactions' => 'Penukaran Hari Ini',
        'money_out' => 'Uang Keluar',
        'processed_orders' => 'Pesanan Diproses',
        'transactions' => 'transaksi',
        'orders' => 'pesanan'
    ],
    'monthly_summary' => [
        'title' => 'Rekapan Jenis Sampah Bulanan',
        'time_range' => 'Jarak Waktu: ',
        'chart_legend' => 'Legend Grafik',
        'monthly_stats' => 'Statistik Bulanan',
        'active_users' => 'Pengguna Aktif',
        'most_ordered_trash' => 'Jenis Sampah Terbanyak',
        'total_transactions' => 'Total Transaksi'
    ],
    'stats' => [
        'trash_in' => 'SAMPAH MASUK',
        'total_expenses' => 'TOTAL PENGELUARAN',
        'active_drivers' => 'PENGEMUDI BULAN INI',
        'active_users' => 'PENGGUNA BULAN INI',
        'kg' => 'KG',
        'people' => 'orang'
    ],
    'transaction_history' => [
        'title' => 'Histori Transaksi',
        'columns' => [
            'order_id' => 'Order ID',
            'date_time' => 'Waktu & Tanggal',
            'user' => 'Pengguna',
            'driver' => 'Penjemput',
            'trash_type' => 'Tipe Sampah',
        ],
        'statuses' => [
            'shipped' => 'Terkirim',
            'pending' => 'Pending',
            'no_status' => 'No Status'
        ],
        'view_all' => 'Lihat Semua Histori'
    ],
    'approval_tasks' => [
        'title' => 'Tugas Persetujuan',
        'statuses' => [
            'unapproved' => 'Tidak di setujui',
            'no_approval' => 'Belum di setujui',
            'not_completed' => 'Belum Selesai',
            'completion_time' => 'Waktu Selesai'
        ],
        'approve_deny' => 'Setujui/Tolak'
    ]
];
