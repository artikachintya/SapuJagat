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
        'exist' => 'You still have ongoing order'
    ],
    'withdrawal' => [
        'errors' => [
            'unauthorized' => 'You do not have permission to make withdrawals.',
            'insufficient_balance' => 'Insufficient balance for this withdrawal.',
        ],
        'success' => [
            'request_submitted' => 'Withdrawal request successfully submitted.',
        ],
        'activity' => [
            'failed_role' => 'Failed withdrawal: role not allowed',
            'failed_balance' => 'Failed withdrawal: insufficient balance',
            'success' => 'Successfully submitted withdrawal request',
        ],
    ],
    'laporan' => 'Report sent successfully',
    'google' => 'This account login with Google. Please continue via Google.',
    'alerts' => [
        'already_registered' => 'This email is already registered, please login.',
        'non_google_account' => 'This email is registered without Google. Please login with email and password.',
        'registration_success' => 'Email successfully registered. Please login to continue.',
        'not_registered' => 'Your Google account is not registered yet.',
         'success' => 'Pendaftaran berhasil!',
        'error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
        'user_not_found' => 'User not found',
        'otp_resent' => 'OTP resent',
        'otp_failed' => 'Failed to resend OTP',
        'otp_invalid' => 'Invalid or expired OTP',
        'role_invalid' => 'Unrecognized role',
    ],
    'messages' => [
        'otp_resent' => 'OTP has been resent',
        'cancel_success' => 'OTP process cancelled',
    ],
];



