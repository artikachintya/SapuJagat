<?php
return [
    'validation' => [
        'order_id' => [
            'required' => 'Order wajib dipilih.',
            'exists' => 'Order tidak ditemukan.',
        ],
        'user_id' => [
            'required' => 'User wajib dipilih.',
            'exists' => 'User tidak ditemukan.',
        ],
        'status' => [
            'in' => 'Status harus bernilai 0 atau 1.',
        ],
    ],
];
