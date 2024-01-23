<?php

return [
    'name' => 'Transaction',
    'live' => [
        'token' => env('MY_FATOORAH_LIVE_TOKEN'),
        'url' => env('MY_FATOORAH_LIVE_URL'),
    ],
    'sandbox' => [
        'token' => env('MY_FATOORAH_SANDBOX_TOKEN'),
        'url' => env('MY_FATOORAH_SANDBOX_URL'),
    ],
    'mode' => env('MY_FATOORAH_MODE', 'sandbox')
];
