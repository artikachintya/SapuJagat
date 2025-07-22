<?php

return [
    'title' => 'Register - Sapu Jagat',
    'quote' => [
        'text' => '"No action is small when done together. Sort your trash today, save the world for tomorrow\'s generation!"',
        'author' => '~By Copitol~'
    ],
    'form' => [
        'title' => 'Register',
        'fields' => [
            'name' => 'Full Name',
            'email' => 'Email',
            'password' => 'Password',
            'address' => 'Address',
            'province' => 'Province',
            'city' => 'City',
            'postal_code' => 'Postal Code',
            'nik' => 'National ID Number',
            'phone_num' => 'Phone Number'
        ],
        'placeholders' => [
            'name' => 'Enter your full name',
            'email' => 'Enter your email',
            'password' => 'Enter your password',
            'address' => 'Enter your address',
            'province' => 'Select Province',
            'city' => 'Select City',
            'postal_code' => 'Enter your postal code',
            'nik' => 'Enter your national ID number',
            'phone_num' => 'Enter your phone number'
        ],
        'buttons' => [
            'google' => 'Register with Google',
            'register' => 'Register',
            'login' => 'Login with Account'
        ]
    ],
    'validation' => [
        'required' => 'This field is required'
    ]
];
