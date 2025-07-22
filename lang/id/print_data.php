<?php

return [
        'title' => 'Cetak Data',
        'filter' => [
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Akhir',
            'category' => 'Kategori',
            'category_placeholder' => 'Pilih Kategori',
            'category_options' => [
                'order' => 'Sampah',
                'withdraw' => 'Penarikan'
            ],
            'submit' => 'Tampilkan'
        ],
        'invoice' => [
            'company' => 'Sapu Jagat, Inc.',
            'date' => 'Tanggal: :date',
            'from' => 'Dari',
            'no_data' => 'Tidak ada data pada periode ini.',
            'total_weight' => 'Total Berat:',
            'total_amount' => 'Total:',
            'generate_pdf' => 'Generate PDF'
        ],
        'table' => [
            'no' => 'No',
            'trash_name' => 'Nama Sampah',
            'type' => 'Type',
            'total' => 'Total',
            'bank' => 'Bank',
            'total_withdraw' => 'Total Penarikan'
        ],
        'errors' => [
            'error' => 'Error: :message'
        ]
];
