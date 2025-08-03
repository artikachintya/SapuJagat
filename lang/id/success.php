<?php

return [
    'profile' => 'Profile berhasil diperbarui!',
    'trash' => [
        'store_success' => 'Jenis sampah berhasil ditambahkan.',
        'update_success' => 'Jenis sampah berhasil diperbarui.',
        'delete_success' => 'Jenis sampah berhasil dihapus.',
        'restore_success' => 'Jenis sampah berhasil dipulihkan.',
        'force_delete_success' => 'Jenis sampah dihapus permanen.',
        'import_success' => ':inserted data berhasil diimport, :skipped duplikat diabaikan.',
    ],
    'assignment' => [
        'store_success' => 'Penugasan #:id berhasil dibuat.',
        'delete_success' => 'Penugasan berhasil dihapus!',
        'restore_success' => 'Penugasan berhasil dipulihkan.',
        'force_delete_success' => 'Penugasan dihapus permanen.',
    ],
    'approval' => [
        'status' => [
            'rejected' => 'Ditolak',
            'approved' => 'Disetujui',
            'pending' => 'Menunggu',
            'processed' => 'Diproses',
        ],
        'store_success' => 'Order #:order_id telah direspons: :status.',
        'stats' => [
            'approved_today' => 'Disetujui Hari Ini',
            'rejected_total' => 'Total Ditolak',
            'approved_total' => 'Total Disetujui',
        ],
    ],
    'respon' => 'Respon berhasil dikirim.',
    'update_user' => 'Status user diperbarui',
    'exchange' => [
        'errors' => [
            'incomplete_address' => 'Silakan lengkapi alamat Anda terlebih dahulu.',
            'max_weight' => 'Maksimal berat untuk setiap jenis sampah adalah 10 kg.',
            'no_selection' => 'Silakan pilih dan tentukan jumlah sampah terlebih dahulu sebelum melanjutkan proses penukaran.',
            'min_weight' => 'Mohon maaf, penukaran tidak dapat diproses. Total berat sampah harus minimal 3 kg.',
            'active_order' => 'Anda masih memiliki pesanan yang sedang diproses.',
            'data_not_found' => 'Data pesanan tidak ditemukan.',
        ],
        'success' => [
            'order_created' => 'Pesanan penjemputan berhasil dikirim!',
        ],
       'exist' => 'Anda masih memiliki pesanan yang sedang diproses'
    ],
     'withdrawal' => [
        'errors' => [
            'unauthorized' => 'Anda tidak memiliki akses untuk melakukan penarikan.',
            'insufficient_balance' => 'Saldo tidak mencukupi untuk penarikan ini.',
        ],
        'success' => [
            'request_submitted' => 'Permintaan penarikan berhasil diajukan.',
        ],
        'activity' => [
            'failed_role' => 'Gagal tarik saldo: role tidak diizinkan',
            'failed_balance' => 'Gagal tarik saldo: saldo tidak mencukupi',
            'success' => 'Berhasil mengajukan penarikan saldo',
        ],
    ],
    'laporan' => 'Laporan berhasil dikirim',

    'google' => 'Akun ini menggunakan login Google. Silakan login melalui Google.',
    'alerts' => [
        'already_registered' => 'Email ini sudah terdaftar, silakan login.',
        'non_google_account' => 'Email ini terdaftar tidak dengan akun Google. Silakan login dengan email dan password.',
        'registration_success' => 'Email berhasil terdaftar. Silakan login untuk melanjutkan.',
        'not_registered' => 'Akun Google Anda belum terdaftar.',
         'success' => 'Pendaftaran berhasil!',
        'error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
        'user_not_found' => 'User tidak ditemukan',
        'otp_resent' => 'OTP dikirim ulang',
        'otp_failed' => 'Gagal mengirim ulang OTP',
        'otp_invalid' => 'OTP salah atau kedaluwarsa',
        'role_invalid' => 'Role tidak dikenali',
    ],

    'messages' => [
        'otp_resent' => 'OTP telah dikirim ulang',
        'cancel_success' => 'Proses OTP dibatalkan',
    ],
];



