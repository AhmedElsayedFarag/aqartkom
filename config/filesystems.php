<?php

return [

    'location_storage' => env('STORAGE_LOCATION', 'local'),
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        'banners' => [
            'driver' => 'local',
            'root' => storage_path('app/public/banners'),
            'url' => env('APP_URL') . '/storage/banners',
            'visibility' => 'public',
            'throw' => false,
        ],
        'estates' => [
            'driver' => 'local',
            'root' => storage_path('app/public/estates'),
            'url' => env('APP_URL') . '/storage/estates',
            'visibility' => 'public',
            'throw' => false,
        ],
        'companies' => [
            'driver' => 'local',
            'root' => storage_path('app/public/companies'),
            'url' => env('APP_URL') . '/storage/companies',
            'visibility' => 'public',
            'throw' => false,
        ],
        'marketers' => [
            'driver' => 'local',
            'root' => storage_path('app/public/marketers'),
            'url' => env('APP_URL') . '/storage/marketers',
            'visibility' => 'public',
            'throw' => false,
        ],
        'categories' => [
            'driver' => 'local',
            'root' => storage_path('app/public/categories'),
            'url' => env('APP_URL') . '/storage/categories',
            'visibility' => 'public',
            'throw' => false,
        ],
        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media'),
            'url' => env('APP_URL') . '/storage/media',
            'visibility' => 'public',
            'throw' => false,
        ],
        'profile' => [
            'driver' => 'local',
            'root' => storage_path('app/public/profile'),
            'url' => env('APP_URL') . '/storage/profile',
            'visibility' => 'public',
            'throw' => false,
        ],
        'documents' => [
            'driver' => 'local',
            'root' => storage_path('app/public/documents'),
            'url' => env('APP_URL') . '/storage/documents',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL') . '/' . env('AWS_OWNER_ID') . ":" . env('AWS_BUCKET'),
            'endpoint' => env('AWS_ENDPOINT') . '/' . env('AWS_OWNER_ID') . ":" . env('AWS_BUCKET'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'owner_id' => env('AWS_OWNER_ID'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
