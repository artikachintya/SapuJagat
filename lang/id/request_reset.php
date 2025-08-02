<?php
return [
    'validation' => [
        'token' => [
            'required' => 'Token wajib diisi.',
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'email' => 'Format email tidak valid.',
        ],
        'password' => [
            'required' => 'Password wajib diisi.',
            'string' => 'Password harus berupa teks.',
            'min' => 'Password harus minimal 8 karakter.',
            'regex' => 'Password harus mengandung minimal satu huruf kapital dan satu karakter spesial.',
            'confirmed' => 'Konfirmasi password tidak cocok.',
        ],
    ],
];
