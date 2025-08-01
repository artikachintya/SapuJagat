<?php
return [
    'validation' => [
        'laporan' => [
            'required' => 'The report content is required.',
            'string' => 'The report content must be text.',
        ],
        'gambar' => [
            'image' => 'The uploaded file must be an image.',
            'max' => 'Maximum image size is 2MB.',
        ],
    ],
];
