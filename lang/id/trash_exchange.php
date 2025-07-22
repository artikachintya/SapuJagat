<?php

return [
    'title' => 'Tukar Sampah',

    'headers' => [
        'organic' => 'Organik',
        'inorganic' => 'Anorganik'
    ],
    'labels' => [
        'select_trash' => 'Pilih Sampah yang Ingin Ditukar',
        'next_button' => 'Lanjut'
    ],
    'validation' => [
        'no_selection' => 'Silakan pilih jenis sampah dan berat terlebih dahulu.',
        'max_weight' => 'Setiap jenis sampah memiliki batas maksimum :max kg. Mohon tidak melebihi batas tersebut.',
        'min_total' => 'Total minimum sampah yang dapat ditukar adalah :min kg.',
    ],

    'address_modal' => [
        'title' => 'Lengkapi Alamat Terlebih Dahulu',
        'message' => 'Mohon lengkapi informasi alamat Anda (alamat lengkap, provinsi, kota, dan kode pos) terlebih dahulu untuk melanjutkan proses penukaran sampah.',
        'button' => 'Atur Profil'
    ]
];
