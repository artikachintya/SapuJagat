<?php

return [
    'create' => [
        'title' => 'Buat Laporan',
        'breadcrumb' => 'Daftar Laporan',
        'form' => [
            'title' => 'Keluhan :name',
            'report_label' => 'Laporan',
            'upload_label' => 'Unggah',
            'submit_button' => 'Kirim',
            'image_preview' => 'Preview Gambar'
        ]
    ],
    'detail' =>'Lihat Detail', 
    'index' => [
        'title' => 'Daftar Laporan',
        'status' => [
            'responded' => 'Sudah Ditanggapi',
            'waiting' => 'Menunggu Respon'
        ],
        'modal' => [
            'date' => 'Hari/Tgl',
            'report_content' => 'Isi Laporan',
            'evidence_photo' => 'Foto Bukti',
            'admin_response' => 'Respon Admin Terakhir - ',
            'no_response' => 'Belum ada respon',
            'close' => 'Tutup'
        ]
    ],
    'common' => [
        'no_photo' => 'Tidak ada foto yang diunggah',
        'success_message' => 'Operasi berhasil diselesaikan'
    ]
];
