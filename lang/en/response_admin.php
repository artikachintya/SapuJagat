<?php

return [
    'title' => 'Report Response',
    'page_title' => 'User Reports List',
    'table_title' => 'User Reports Table',

    'table' => [
        'headers' => [
            'id' => 'ID',
            'user_id' => 'User ID',
            'reporter_name' => 'Reporter Name',
            'report_content' => 'Report Content',
            'report_date' => 'Report Date',
            'response_date' => 'Response Date',
            'status' => 'Status',
            'actions' => 'Actions'
        ],
        'status' => [
            'responded' => 'Responded',
            'pending' => 'Pending'
        ],
        'action_button' => 'Details'
    ],

    'modal' => [
        'title' => 'Report Details #:id',
        'fields' => [
            'user_id' => 'User ID',
            'reporter_name' => 'Reporter Name',
            'report_content' => 'Report Content',
            'report_date' => 'Report Date',
            'response_date' => 'Response Date',
            'status' => 'Status',
            'photo' => 'Evidence Photo',
            'response_content' => 'Response Content',
            'admin' => 'Admin'
        ],
        'response_form' => [
            'label' => 'Write Admin Response:',
            'submit' => 'Send Response'
        ],
        'close_button' => 'Close'
    ],

    'alerts' => [
        'success' => ':message'
    ]
];
