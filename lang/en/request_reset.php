<?php
return [
    'validation' => [
        'token' => [
            'required' => 'Token is required.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'email' => 'Invalid email format.',
        ],
        'password' => [
            'required' => 'Password is required.',
            'string' => 'Password must be a string.',
            'min' => 'Password must be at least 8 characters.',
            'regex' => 'Password must contain at least one uppercase letter and one special character.',
            'confirmed' => 'Password confirmation does not match.',
        ],
    ],
];
