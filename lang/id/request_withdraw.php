<?php
return [
    'validation' => [
        'amount' => [
            'required' => 'Nominal penarikan wajib diisi.',
            'numeric' => 'Nominal harus berupa angka.',
            'min' => 'Nominal minimal penarikan adalah Rp50.000.',
        ],
        'bank' => [
            'required' => 'Nama bank wajib diisi.',
            'in' => 'Bank harus salah satu dari: BCA, MANDIRI, atau BRI.',
        ],
        'number' => [
            'required' => 'Nomor rekening wajib diisi.',
            'string' => 'Nomor rekening harus berupa teks.',
            'max' => 'Nomor rekening maksimal 30 karakter.',
        ],
    ],
];      
