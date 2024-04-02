<?php
return [
    'esewa' =>[
        'product_code' => env('ESEWA_PRODUCT_CODE'),
        'url' => env('ESEWA_URL'),
        'mode' => env('ESEWA_MODE') ?? '0', //developing ==0 or production == 1
        'default_url' => [
            0 => 'https://rc-epay.esewa.com.np/api/epay/main/v2/form',
            1 => 'https://epay.esewa.com.np/api/epay/main/v2/form',
        ],
    ],
    'khalti' =>[
        'secret_key' => env('KHALTI_SECRET_KEY'),
        'url' => env('KHALTI_API_ENDPOINT'),
        'mode' => env('KHALTI_MODE') ?? '0', //developing ==0 or production == 1
        'default_url' => [
            0 => 'https://a.khalti.com/api/v2/',
            1 => 'https://khalti.com/api/v2/',
        ],
        'callback_url' => env('KHALTI_CALLBACK_URL'),
    ],
];
?>