<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Loader
    |--------------------------------------------------------------------------
    |
    | Select which breadcrumb loader your application will use. The default option
    | is to read a local JSON file, but it's also possible to create your own.
    |
    | Supported: "custom", "json"
    |
    */

    'loader' => env('BREADCRUMB_LOADER', 'json'),

    /*
    |--------------------------------------------------------------------------
    | Loaders
    |--------------------------------------------------------------------------
    |
    | Set loader-specific options here. "json" will read a local JSON file, while
    | "custom" points to a factory class that returns a loader from its `__invoke`
    | method.
    |
    */

    'loaders' => [
        'custom' => [
            //'via' => \App\CreateBreadcrumbLoader::class,
        ],
        'json' => [
            'path' => env('BREADCRUMB_JSON_PATH', resource_path('breadcrumbs.json')),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | View Partial
    |--------------------------------------------------------------------------
    |
    | Set your breadcrumb view partial here. We default to a Bootstrap
    | "custom" points to a factory class that returns a loader from its `__invoke`
    | method.
    |
    */

    'view' => env('BREADCRUMB_VIEW', 'breadcrumbs::bootstrap'),
];