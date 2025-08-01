<?php
return [
    'validation' => [
        'order_id' => [
            'required' => 'Order must be selected.',
            'exists' => 'Invalid order.',
        ],
        'user_id' => [
            'required' => 'User must be selected.',
            'exists' => 'Invalid user.',
        ],
        'notes' => [
            'required' => 'Notes are required.',
            'string' => 'Notes must be text.',
        ],
        'approval_status' => [
            'required' => 'Approval status is required.',
            'in' => 'Approval status must be 0 (rejected), 1 (approved), or 2 (revision).',
        ],
    ],
    'status_options' => [
        0 => 'Rejected',
        1 => 'Approved',
        2 => 'Revision',
    ],
];
