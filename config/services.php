<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],



    'nexmo' => [
        'sms_from' => 'App Store',
    ],

    'currency-converter' => [
        'key' => 'do-not-use-this-key',
    ],

    'moyasar' => [
        'key' => 'pk_test_nNizhxbmqDUr3kRUYppLawfEVi2QYVo3gbC1z7qs',
        'secret' => 'sk_test_m8Y3acUkayhhTP4eqMVp7bu7iSpsPDyRtgYhe6QW',
    ],

];
