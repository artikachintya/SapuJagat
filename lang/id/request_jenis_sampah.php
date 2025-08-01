<?php

return [
    'name' => [
        'required' => 'Nama sampah wajib diisi.',
        'string' => 'Nama sampah harus berupa teks.',
        'max' => 'Nama sampah maksimal 255 karakter.'
    ],
    'photos' => [
        'required' => 'Foto sampah wajib diunggah.',
        'image' => 'File harus berupa gambar.',
        'mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'max' => 'Ukuran gambar maksimal 2MB.'
    ],
    'type' => [
        'required' => 'Jenis sampah wajib diisi.',
        'string' => 'Jenis sampah harus berupa teks.',
        'max' => 'Jenis sampah maksimal 255 karakter.'
    ],
    'price_per_kg' => [
        'required' => 'Harga per kg wajib diisi.',
        'numeric' => 'Harga per kg harus berupa angka.'
    ],
    'max_weight' => [
        'required' => 'Berat maksimal wajib diisi.',
        'numeric' => 'Berat maksimal harus berupa angka.'
    ]
];
