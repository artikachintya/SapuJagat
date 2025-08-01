<?php
return [
    'validation' => [
        'name' => [
            'required' => 'Full name is required.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'email' => 'Invalid email format.',
            'unique' => 'Email already registered.',
        ],
        'password' => [
            'min' => 'Password must be at least 8 characters.',
            'regex' => 'Password must contain uppercase and special characters.',
        ],
        'address' => [
            'required' => 'Address is required.',
        ],
        'province' => [
            'required' => 'Province is required.',
        ],
        'city' => [
            'required' => 'City is required.',
        ],
        'postal_code' => [
            'required' => 'Postal code is required.',
            'digits_between' => 'Postal code must be 4-6 digits.',
        ],
        'phone_num' => [
            'required' => 'Phone number is required.',
            'digits_between' => 'Phone number must be 8-15 digits.',
        ],
        'profile_pic' => [
            'image' => 'File must be an image.',
            'max' => 'Maximum image size is 2MB.',
        ],
    ],
    'messages' => [
        'update_success' => 'Profile updated successfully.',
    ],
];
