<?php

return [
    'create' => [
        'title' => 'Create Report',
        'breadcrumb' => 'Report List',
        'form' => [
            'title' => 'Report from :name',
            'report_label' => 'Report',
            'upload_label' => 'Upload',
            'submit_button' => 'Submit',
            'image_preview' => 'Image Preview'
        ]
    ],
    'detail' =>'View Detail',
    'index' => [
        'title' => 'Report List',
        'status' => [
            'responded' => 'Responded',
            'waiting' => 'Waiting for Response'
        ],
        'modal' => [
            'date' => 'Date',
            'report_content' => 'Report Content',
            'evidence_photo' => 'Evidence Photo',
            'admin_response' => 'Latest Admin Response - ',
            'no_response' => 'No response yet',
            'close' => 'Close'
        ]
    ],
    'common' => [
        'no_photo' => 'No photo uploaded',
        'success_message' => 'Operation completed successfully'
    ]
];
