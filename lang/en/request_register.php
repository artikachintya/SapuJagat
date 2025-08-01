<?php
return [
    'validation' => [
        'name' => [
            'required' => 'Full name is required.',
            'max' => 'Name must not exceed 255 characters.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'email' => 'Invalid email format.',
            'unique' => 'Email already registered.',
        ],
        'password' => [
            'required' => 'Password is required.',
            'min' => 'Password must be at least 8 characters.',
            'regex' => 'Password must contain uppercase letters and special characters.',
        ],
        'address' => [
            'required' => 'Address is required.',
            'max' => 'Address must not exceed 255 characters.',
        ],
        'province' => [
            'required' => 'Province is required.',
            'max' => 'Province must not exceed 100 characters.',
        ],
        'city' => [
            'required' => 'City is required.',
            'max' => 'City must not exceed 100 characters.',
        ],
        'postal_code' => [
            'required' => 'Postal code is required.',
            'digits_between' => 'Postal code must be 4-6 digits.',
        ],
        'NIK' => [
            'required' => 'National ID (NIK) is required.',
            'digits' => 'NIK must be exactly 16 digits.',
            'unique' => 'This NIK is already registered.',
        ],
        'phone_num' => [
            'required' => 'Phone number is required.',
            'digits_between' => 'Phone number must be 8-15 digits.',
            'unique' => 'This phone number is already in use.',
        ],
    ],
];
