<?php
return [
    'validation' => [
        'name' => [
            'required' => 'Nama lengkap wajib diisi.',
            'max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'email' => 'Format email tidak valid.',
            'unique' => 'Email sudah terdaftar.',
        ],
        'password' => [
            'required' => 'Kata sandi wajib diisi.',
            'min' => 'Kata sandi harus minimal 8 karakter.',
            'regex' => 'Kata sandi harus mengandung huruf besar dan karakter spesial.',
        ],
        'address' => [
            'required' => 'Alamat wajib diisi.',
            'max' => 'Alamat tidak boleh lebih dari 255 karakter.',
        ],
        'province' => [
            'required' => 'Provinsi wajib dipilih.',
            'max' => 'Provinsi tidak boleh lebih dari 100 karakter.',
        ],
        'city' => [
            'required' => 'Kota wajib dipilih.',
            'max' => 'Kota tidak boleh lebih dari 100 karakter.',
        ],
        'postal_code' => [
            'required' => 'Kode pos wajib diisi.',
            'digits_between' => 'Kode pos harus 4-6 digit.',
        ],
        'NIK' => [
            'required' => 'NIK wajib diisi.',
            'digits' => 'NIK harus terdiri dari 16 digit.',
            'unique' => 'NIK ini sudah terdaftar.',
        ],
        'phone_num' => [
            'required' => 'Nomor telepon wajib diisi.',
            'digits_between' => 'Nomor telepon harus 8-15 digit.',
            'unique' => 'Nomor telepon ini sudah digunakan.'
        ],
    ],
];
