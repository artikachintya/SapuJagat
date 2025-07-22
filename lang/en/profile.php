<?php

return [
    'title' => 'My Profile',
    'edit_title' => 'Edit Profile',
    'edit' => 'Edit Profile',
    'header' => [
        'admin' => 'Admin Profile Information',
        'driver' => 'Driver Profile Information',
        'pengguna' => 'User Profile Information',
        'admin_title' => 'Admin Profile',
        'user_title' => 'User Profile',

    ],
    'fields' => [
        'full_name' => 'Full Name',
        'nik' => 'NIK',
        'email' => 'Email',
        'password' => 'Password',
        'phone' => 'Phone Number',
        'address' => 'Address',
        'postal_code' => 'Postal Code',
        'province' => 'Province',
        'city' => 'City',
        'license_plate' => 'Vehicle Plate'
    ],
    'placeholders' => [
        'password' => '********',
        'province' => 'Select Province',
        'city' => 'Select City'
    ],
    'validation' => [
        'name_required' => 'Full name is required',
        'email_invalid' => 'Invalid email format',
        'password_rules' => 'Minimum 8 characters, 1 uppercase letter & 1 symbol',
        'phone_digits' => 'Phone number must be 8-15 digits',
        'license_required' => 'License plate is required'
    ],
    'buttons' => [
        'save' => 'Save Changes',
        'cancel' => 'Cancel',
        'confirm' => 'Yes, Save',
        'change_photo' => 'Change Photo'
    ],
    'modal' => [
        'title' => 'Confirm Save Changes',
        'body' => 'Are you sure you want to save these changes?'
    ],
    'no_changes' => 'No changes detected',
    'update_success' => 'Profile updated successfully',
    'update_error' => 'Failed to update profile'
];
