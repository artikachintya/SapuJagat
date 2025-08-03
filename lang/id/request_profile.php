<?php
return [
    'validation' => [
        'name' => [
            'required' => 'Nama lengkap wajib diisi.',
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'email' => 'Format email tidak valid.',
            'unique' => 'Email sudah terdaftar.',
        ],
        'password' => [
            'min' => 'Password minimal 8 karakter.',
            'regex' => 'Password harus mengandung huruf besar dan karakter spesial.',
        ],
        'address' => [
            'required' => 'Alamat wajib diisi.',
        ],
        'province' => [
            'required' => 'Provinsi wajib dipilih.',
        ],
        'city' => [
            'required' => 'Kota wajib dipilih.',
        ],
        'postal_code' => [
            'required' => 'Kode pos wajib diisi.',
            'digits_between' => 'Kode pos harus 4-6 digit.',
        ],
        'phone_num' => [
            'required' => 'Nomor telepon wajib diisi.',
            'digits_between' => 'Nomor telepon harus 8-15 digit.',
        ],

        'license_plate' => [
            'required' => 'Nomor plat wajib diisi.',
            'string' => 'Nomor plat harus berupa teks.',
            'regex' => 'Format plat nomor tidak valid. Contoh: B1234XYZ',
        ],
        'profile_pic' => [
            'image' => 'Foto profil harus berupa file gambar.',
            'mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.',
            'max' => 'Ukuran gambar maksimal 2MB.',
        ],

    ],
    'messages' => [
        'update_success' => 'Profil berhasil diperbarui.',
    ],
];
