<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Settings
    |--------------------------------------------------------------------------
    |
    | You can configure the dashboard settings from here.
    |
    */

    'dashboard' => [

        'port' => env('LARAVEL_WEBSOCKETS_PORT', 6001),

        'domain' => env('LARAVEL_WEBSOCKETS_DOMAIN'),

        'path' => env('LARAVEL_WEBSOCKETS_PATH', 'laravel-websockets'),

        'middleware' => [
            'web',
            \BeyondCode\LaravelWebSockets\Dashboard\Http\Middleware\Authorize::class,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Applications Repository
    |--------------------------------------------------------------------------
    |
    | By default, the only allowed app is the one you define with
    | your PUSHER_* variables from .env.
    | You can configure to use multiple apps if you need to, or use
    | a custom App Manager that will handle the apps from a database, per se.
    |
    | You can apply multiple settings, like the maximum capacity, enable
    | client-to-client messages or statistics.
    |
    */

    'apps' => [
        [
            'id' => env('PUSHER_APP_ID'),
            'name' => env('APP_NAME'),
            'host' => env('PUSHER_APP_HOST'),
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'path' => env('PUSHER_APP_PATH'),
            'capacity' => null,
            'enable_client_messages' => false,
            'enable_statistics' => true,
            'allowed_origins' => [
                // env('LARAVEL_WEBSOCKETS_DOMAIN'),
            ],
        ],
    ],

    /*
     * This class is responsible for finding the apps. The default provider
     * will use the apps defined in this config file.
     *
     * You can create a custom provider by implementing the
     * `AppProvider` interface.
     */
    'app_provider' => BeyondCode\LaravelWebSockets\Apps\ConfigAppProvider::class,

    /*
     * This array contains the hosts of which you want to allow incoming requests.
     * Leave this empty if you want to accept requests from all hosts.
     */
    'allowed_origins' => [
        //
    ],

    /*
     * The maximum request size in kilobytes that is allowed for an incoming WebSocket request.
     */
    'max_request_size_in_kb' => 250,

    /*
     * This path will be used to register the necessary routes for the package.
     */
    'path' => 'laravel-websockets',

    'statistics' => [
        /*
         * This model will be used to store the statistics of the WebSocketsServer.
         * The only requirement is that the model should extend
         * `WebSocketsStatisticsEntry` provided by this package.
         */
        'model' => \BeyondCode\LaravelWebSockets\Statistics\Models\WebSocketsStatisticsEntry::class,

        /*
         * Here you can specify the interval in seconds at which statistics should be logged.
         */
        'interval_in_seconds' => 60,

        /*
         * When the clean-command is executed, all recorded statistics older than
         * the number of days specified here will be deleted.
         */
        'delete_statistics_older_than_days' => 60,

        /*
         * Use an DNS resolver to make the requests to the statistics logger
         * default is to resolve everything to 127.0.0.1.
         */
        'perform_dns_lookup' => false,
    ],


    'ssl' => [

        'local_cert' => env('LARAVEL_WEBSOCKETS_SSL_LOCAL_CERT', null),

        'capath' => env('LARAVEL_WEBSOCKETS_SSL_CA', null),

        'local_pk' => env('LARAVEL_WEBSOCKETS_SSL_LOCAL_PK', null),

        'passphrase' => env('LARAVEL_WEBSOCKETS_SSL_PASSPHRASE', null),

        'allow_self_signed' => TRUE, // Allow self signed certs (should be false in production)

        'verify_peer' => FALSE

//        'verify_peer' => env('APP_ENV') === 'production',
//
//        'allow_self_signed' => env('APP_ENV') !== 'production',

    ],

    /*
    |--------------------------------------------------------------------------
    | Route Handlers
    |--------------------------------------------------------------------------
    |
    | Here you can specify the route handlers that will take over
    | the incoming/outgoing websocket connections. You can extend the
    | original class and implement your own logic, alongside
    | with the existing logic.
    |
    */

    'handlers' => [

        'websocket' => \BeyondCode\LaravelWebSockets\Server\WebSocketHandler::class,

        'health' => \BeyondCode\LaravelWebSockets\Server\HealthHandler::class,

        'trigger_event' => \BeyondCode\LaravelWebSockets\API\TriggerEvent::class,

        'fetch_channels' => \BeyondCode\LaravelWebSockets\API\FetchChannels::class,

        'fetch_channel' => \BeyondCode\LaravelWebSockets\API\FetchChannel::class,

        'fetch_users' => \BeyondCode\LaravelWebSockets\API\FetchUsers::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Promise Resolver
    |--------------------------------------------------------------------------
    |
    | The promise resolver is a class that takes a input value and is
    | able to make sure the PHP code runs async by using ->then(). You can
    | use your own Promise Resolver. This is usually changed when you want to
    | intercept values by the promises throughout the app, like in testing
    | to switch from async to sync.
    |
    */

    'promise_resolver' => \React\Promise\FulfilledPromise::class,

];
