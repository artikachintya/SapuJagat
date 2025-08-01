<?php
return [
    'validation' => [
        'report_id' => [
            'required' => 'Laporan wajib dipilih.',
            'exists' => 'Laporan tidak ditemukan.',
        ],
        'user_id' => [
            'required' => 'User wajib dipilih.',
            'exists' => 'User tidak valid.',
        ],
        'response_message' => [
            'required' => 'Pesan tanggapan wajib diisi.',
            'string' => 'Pesan harus berupa teks.',
            'max' => 'Pesan maksimal 255 karakter.',
        ],
    ],
];
