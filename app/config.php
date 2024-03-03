<?php
$config['settings'] = [
    'displayErrorDetails' => true,
    'APP_NAME' => $_ENV[APP_PREFIX . 'APP_NAME'],
    'ENV' => $_ENV['ENV'],
    'LOG_FILE' => $_ENV[APP_PREFIX . 'LOG_FILE'],
    'LOG_CONSOLE' => filter_var(
        $_ENV[APP_PREFIX . 'LOG_CONSOLE'],
        FILTER_VALIDATE_BOOLEAN,
        ['default' => false]
    ),
    'SENTRY_ENABLED' => filter_var(
        $_ENV[APP_PREFIX . 'SENTRY_ENABLED'],
        FILTER_VALIDATE_BOOLEAN,
        ['default' => true]
    ),
    'SENTRY_DSN' => $_ENV[APP_PREFIX . 'SENTRY_DSN'],
    'SENTRY_OPTIONS' => [
        'verify_ssl' => filter_var(
            $_ENV[APP_PREFIX . 'SENTRY_VERIFY_SSL'],
            FILTER_VALIDATE_BOOLEAN,
            ['default' => false]
        ),
        'environment' => strtolower($_ENV['ENV']),
    ],
    'DEBUG' => filter_var(
        $_ENV[APP_PREFIX . 'DEBUG'],
        FILTER_VALIDATE_BOOLEAN,
        ['default' => false]
    ),
    'REDIS_SERVER' =>  $_ENV[APP_PREFIX . 'REDIS_SERVER'],
    'REDIS_PORT' =>  $_ENV[APP_PREFIX . 'REDIS_PORT'],
    'REDIS_DB' =>  $_ENV[APP_PREFIX . 'REDIS_DB'],
    'cache.prefix' => $_ENV[APP_PREFIX . 'CACHE_PREFIX'],
];
