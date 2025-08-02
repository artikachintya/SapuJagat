<?php

return [
    'title' => 'Detail Penjemputan',
    'customer' => [
        'default_name' => 'Nama Pelanggan',
        'default_address' => 'Alamat tidak tersedia',
        'default_city' => 'Kota',
        'default_province' => 'Provinsi',
        'default_postal' => 'Kode pos'
    ],
    'elements' => [
        'chat_button' => 'Buka Chat',
        'photo_evidence' => 'Bukti foto',
        'upload_section' => [
            'title' => 'Upload Bukti Pengantaran',
            'preview' => 'Preview'
        ],
        'delivery_notes' => 'Catatan Pengantaran',
    ],
    'buttons' => [
        'start_pickup' => 'Mulai Menjemput',
        'waste_picked' => 'Sampah Diambil',
        'complete_pickup' => 'Penjemputan Selesai'
    ],
    'success_popup' => [
        'title' => '🎉 Yeay! Kamu telah menyelesaikan order!',
        'message' => 'Terima kasih telah menjemput sampah pelanggan.<br>Kamu akan diarahkan ke daftar pickup dalam 5 detik...'
    ],
    'validation' => [
        'photo_required' => 'Foto bukti wajib diunggah'
    ]
];
