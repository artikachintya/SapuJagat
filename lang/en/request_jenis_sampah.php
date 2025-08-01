<?php

return [
    'name' => [
        'required' => 'Waste name is required.',
        'string' => 'Waste name must be text.',
        'max' => 'Waste name maximum 255 characters.'
    ],
    'photos' => [
        'required' => 'Waste photo must be uploaded.',
        'image' => 'File must be an image.',
        'mimes' => 'Image format must be jpg, jpeg, png, or webp.',
        'max' => 'Maximum image size is 2MB.'
    ],
    'type' => [
        'required' => 'Waste type is required.',
        'string' => 'Waste type must be text.',
        'max' => 'Waste type maximum 255 characters.'
    ],
    'price_per_kg' => [
        'required' => 'Price per kg is required.',
        'numeric' => 'Price per kg must be numeric.'
    ],
    'max_weight' => [
        'required' => 'Maximum weight is required.',
        'numeric' => 'Maximum weight must be numeric.'
    ]

];
