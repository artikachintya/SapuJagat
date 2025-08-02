<?php
return [
    'validation' => [
        'order_id' => [
            'required' => 'Order harus dipilih.',
            'exists' => 'Order tidak valid.',
        ],
        'user_id' => [
            'required' => 'User harus dipilih.',
            'exists' => 'User tidak valid.',
        ],
        'notes' => [
            'required' => 'Catatan wajib diisi.',
            'string' => 'Catatan harus berupa teks.',
        ],
        'approval_status' => [
            'required' => 'Status persetujuan wajib diisi.',
            'in' => 'Status persetujuan harus 0 (ditolak), 1 (disetujui), atau 2 (revisi).',
        ],
    ],
    'status_options' => [
        0 => 'Ditolak',
        1 => 'Disetujui',
        2 => 'Revisi',
    ],
];
