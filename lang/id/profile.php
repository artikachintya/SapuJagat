<?php

return [

    'title' => 'Profil Saya',
    'edit_title' => 'Edit Profil',
    'edit' => 'Edit Profil',
    'header' => [
        'admin' => 'Informasi Profil Admin',
        'driver' => 'Informasi Profil Pengemudi',
        'pengguna' => 'Informasi Profil Pengguna',
        'admin_title' => 'Profil Admin',
        'user_title' => 'Profil Pengguna',

    ],
    'fields' => [
        'full_name' => 'Nama Lengkap',
        'nik' => 'NIK',
        'email' => 'Email',
        'password' => 'Kata Sandi',
        'phone' => 'Nomor Telepon',
        'address' => 'Alamat',
        'postal_code' => 'Kode Pos',
        'province' => 'Provinsi',
        'city' => 'Kota',
        'license_plate' => 'Plat Kendaraan'
    ],
    'placeholders' => [
        'password' => '********',
        'province' => 'Pilih Provinsi',
        'city' => 'Pilih Kota'
    ],
    'validation' => [
        'name_required' => 'Nama lengkap wajib diisi',
        'email_invalid' => 'Format email tidak valid',
        'password_rules' => 'Minimal 8 karakter, 1 huruf besar & 1 simbol',
        'phone_digits' => 'Nomor telepon harus 8-15 digit',
        'license_required' => 'Plat nomor wajib diisi'
    ],
    'buttons' => [
        'save' => 'Simpan Perubahan',
        'cancel' => 'Batal',
        'confirm' => 'Ya, Simpan',
        'change_photo' => 'Ubah Foto'
    ],
    'modal' => [
        'title' => 'Konfirmasi Simpan Perubahan',
        'body' => 'Apakah Anda yakin ingin menyimpan perubahan ini?'
    ],
    'no_changes' => 'Tidak ada perubahan terdeteksi',
    'update_success' => 'Profil berhasil diperbarui',
    'update_error' => 'Gagal memperbarui profil'
];
