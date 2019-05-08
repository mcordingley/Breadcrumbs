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

    'loader' => env('BREADCRUMBS_LOADER', 'json'),

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
            'path' => env('BREADCRUMBS_JSON_PATH', resource_path('breadcrumbs.json')),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Formatter
    |--------------------------------------------------------------------------
    |
    | The formatter converts your breadcrumbs into some rendered output. By
    | default, this will simply be a Blade view. But, "custom" will allow
    | a custom factory class to provide an instance of `Formatter`.
    |
    */

    'formatter' => env('BREADCRUMBS_FORMATTER', 'view'),

    /*
    |--------------------------------------------------------------------------
    | Formatters
    |--------------------------------------------------------------------------
    |
    | Set loader-specific options here. "json" will read a local JSON file, while
    | "custom" points to a factory class that returns a loader from its `__invoke`
    | method.
    |
    */

    'formatters' => [
        'custom' => [
            //'via' => \App\CreateBreadcrumbFormatter::class,
        ],
        'view' => [
            'path' => env('BREADCRUMBS_VIEW', 'breadcrumbs::bootstrap'),
        ],
    ],
];