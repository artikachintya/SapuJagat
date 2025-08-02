<?php
return [
    'validation' => [
        'amount' => [
            'required' => 'Withdrawal amount is required.',
            'numeric' => 'Amount must be a number.',
            'min' => 'Minimum withdrawal amount is Rp50,000.',
        ],
        'bank' => [
            'required' => 'Bank name is required.',
            'in' => 'Bank must be one of: BCA, MANDIRI, or BRI.',
        ],
        'number' => [
            'required' => 'Account number is required.',
            'string' => 'Account number must be text.',
            'max' => 'Account number cannot exceed 30 characters.',
        ],
    ],
];
