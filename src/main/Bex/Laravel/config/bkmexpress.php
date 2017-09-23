<?php

/**
 * Bkmexpress config
 */
return [
    'merchant_id'           =>  env('BKM_MID'),
    'private_key'           =>  env('BKM_PRIVATE_KEY'),
    'bank_bin'              =>  env('BKM_POS_BANK_BIN'),
    'environment'           =>  env('BKM_ENVIRONMENT'),
    'nonce_path'            =>  env('BKM_NONCE_PATH'),
    'pos'                   =>  array(
        'user_id'           =>  env('BKM_POS_USER_ID'),
        'password'          =>  env('BKM_POS_PASSWORD'),
        'client_id'         =>  env('BKM_POS_CLIENT_ID'),
        'store_key'         =>  env('BKM_POS_STORE_KEY'),
        'url'               =>  env('BKM_POS_URL')
    )
];