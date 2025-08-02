<?php
return [
    'validation' => [
        'report_id' => [
            'required' => 'Report must be selected.',
            'exists' => 'Report not found.',
        ],
        'user_id' => [
            'required' => 'User must be selected.',
            'exists' => 'Invalid user.',
        ],
        'response_message' => [
            'required' => 'Response message is required.',
            'string' => 'Response must be text.',
            'max' => 'Response must not exceed 255 characters.',
        ],
    ],
];
