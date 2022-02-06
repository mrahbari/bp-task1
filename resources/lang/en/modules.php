<?php

return [
    'breadcrumb' =>
        [
            'home' => 'Home Page'
        ],
    'status' => // 1-> Active / Approved, 2-> Inactive, 3-> Draft, 4-> Archive
        [
            'active' => 'active',
            'inactive' => 'inactive',
            'draft' => 'draft',
            'archive' => 'archive',
            'soft_deleted' => 'Temporary deletion',
        ],
    'boolean' =>
        [
            'true' => 'yes',
            'false' => 'no',
        ],
    'confirm' =>
        [
            'active' => 'active',
            'inactive' => 'inactive',
        ],
    'options' => [
        'status' => [1 => 'active', 2 => 'disabled', 3 => 'draft', 4 => 'archive'],
        'confirm' => [1 => 'Yes', 2 => 'No'],
        'boolean' => [1 => 'Yes', 0 => 'No'],
        'priority' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30],
    ],
    'message' =>
        [
            'succeed' => 'Operation succeeded.',
            'created' => 'Information registration completed successfully.',
            'updated' => 'Information was successfully updated.',
            'deleted' => 'Deleted information was successfully completed.',
            'changed' => 'Information changed successfully.',
            'restored' => 'Information restored successfully.',
            'failed' => 'Operation failed, please try again.',
            'bad_request' => 'Check the accuracy of the requested information.',
            'unauthorized' => 'You are not allowed to view information.',
            'forbidden' => 'You are not allowed to view information.',
            'not_found' => 'The requested information was not found.',
            'accepted' => 'Operation completed successfully.',
            'no_data' => 'No information to display.',
        ],

];
