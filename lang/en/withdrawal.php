<?php

return [
    'title' => 'Withdraw User Balance',
    'breadcrumb' => [
        'home' => 'Dashboard',
        'withdrawal' => 'Withdraw Balance'
    ],
    'balance_box' => [
        'title' => 'Balance',
        'user_balance' => ":name's Balance"
    ],
    'form' => [
        'amount' => [
            'label' => 'Withdrawal Amount',
            'placeholder' => 'Rp Minimum 50,000',
            'info' => 'Funds from trash sales will be transferred to your account within 3 business days.'
        ],
        'transfer_to' => [
            'label' => 'Transfer to',
            'account_number' => 'Account Number:'
        ],
        'submit' => 'Withdraw Funds'
    ],
    'modal' => [
        'title' => 'Edit Bank Information',
        'fields' => [
            'bank_name' => [
                'label' => 'Bank Name',
                'placeholder' => 'BCA/BRI/MANDIRI'
            ],
            'account_number' => [
                'label' => 'Account Number',
                'placeholder' => 'Example: 1234567890'
            ]
        ],
        'buttons' => [
            'cancel' => 'Cancel',
            'save' => 'Save'
        ]
    ],
    'validation' => [
        'min_amount' => 'Minimum withdrawal amount is Rp50,000'
    ]
];
