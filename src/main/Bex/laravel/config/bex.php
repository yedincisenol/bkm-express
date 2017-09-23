<?php

/**
 * Bkmexpress config.
 */
return [
    'merchant_id'           => env('BEX_MID'),
    'private_key'           => env('BEX_PRIVATE_KEY'),
    'bank_bin'              => env('BEX_POS_BANK_BIN'),
    'environment'           => env('BEX_ENVIRONMENT'),
    'nonce_path'            => env('BEX_NONCE_PATH'),
    'pos'                   => [
        'user_id'           => env('BEX_POS_USER_ID'),
        'password'          => env('BEX_POS_PASSWORD'),
        'client_id'         => env('BEX_POS_CLIENT_ID'),
        'store_key'         => env('BEX_POS_STORE_KEY'),
        'url'               => env('BEX_POS_URL'),
    ],
];
