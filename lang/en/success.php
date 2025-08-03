<?php

return [
    'profile' => 'Profile updated successfully!',
    'trash' => [
        'store_success' => 'Trash type successfully added.',
        'update_success' => 'Trash type successfully updated.',
        'delete_success' => 'Trash type successfully deleted.',
        'restore_success' => 'Trash type successfully restored.',
        'force_delete_success' => 'Trash type permanently deleted.',
        'import_success' => ':inserted data successfully imported, :skipped duplicates skipped.',
    ],
     'assignment' => [
        'store_success' => 'Assignment #:id successfully created.',
        'delete_success' => 'Assignment successfully deleted!',
        'restore_success' => 'Assignment successfully restored.',
        'force_delete_success' => 'Assignment permanently deleted.',
    ],
     'approval' => [
        'status' => [
            'rejected' => 'Rejected',
            'approved' => 'Approved',
            'pending' => 'Pending',
            'processed' => 'Processed',
        ],
        'store_success' => 'Order #:order_id has been responded: :status.',
        'stats' => [
            'approved_today' => 'Approved Today',
            'rejected_total' => 'Total Rejected',
            'approved_total' => 'Total Approved',
        ],
    ],
    'respon' => 'Response send successfully',
    'update_user' => 'User status updated.',
    'exchange' => [
        'errors' => [
            'incomplete_address' => 'Please complete your address information first.',
            'max_weight' => 'Maximum weight for each trash type is 10 kg.',
            'no_selection' => 'Please select and specify the quantity of trash before proceeding.',
            'min_weight' => 'Sorry, exchange cannot be processed. Minimum total weight is 3 kg.',
            'active_order' => 'You still have an order being processed.',
            'data_not_found' => 'Order data not found.',
        ],
        'success' => [
            'order_created' => 'Pickup order successfully submitted!',
        ],
        'types' => [
            'organic' => 'Organic',
            'inorganic' => 'Inorganic',
        ],
    ],
];



