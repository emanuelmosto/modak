<?php

/** @var Container $container */

use GuzzleHttp\Client;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Slim\Container;
use Slim\Handlers\Strategies\RequestResponseArgs;

$container = $app->getContainer();

// parse parameters in the url
$container['foundHandler'] = function () {
    return new RequestResponseArgs();
};

$container["logger"] = function ($container) {
    /** @var Container $container */
    $logger = new \Monolog\Logger("slim");

    $formatter = new LineFormatter(
        "[%datetime%] [%level_name%]: %message% %context%\n",
        null,
        true,
        true
    );
    // log level
    $level = $container->get('settings')['DEBUG'] ?
        Logger::DEBUG : Logger::ERROR;
    // allow to choose between console log and files logs
    if ($container->get('settings')['LOG_CONSOLE']) {
        $streamHandler = new \Monolog\Handler\StreamHandler("php://stdout", $level);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);
    } else {
        /* Log to timestamped files */
        $rotating = new \Monolog\Handler\RotatingFileHandler(
            $container->get('settings')['LOG_FILE'],
            0,
            $level
        );
        $rotating->setFormatter($formatter);
        $logger->pushHandler($rotating);
    }

    return $logger;
};

$container["sentry"] = function ($container) {
    /** @var Container $container */
    $client = null;
    if ($container->get('settings')['SENTRY_ENABLED']) {
        $client = new Raven_Client(
            $container->get('settings')['SENTRY_DSN'],
            $container->get('settings')['SENTRY_OPTIONS']
        );
    }
    return $client;
};

$container['http_client'] = function ($container) {
    $whitelistBypass = $container->get('settings')['WHITELIST_BYPASS_HEADER'];
    return new Client([
        'headers' => ['REQUESTED-BY' => $whitelistBypass],
        'timeout' => $container->get('settings')['REQUEST_TIMEOUT']
    ]);
};

$container['cache'] = function ($container) {
    $settings = $container->get('settings');
    $redis = new Redis();
    $redis->connect(
        $_ENV['REDIS_HOST'],
        $settings['REDIS_PORT']
    );

    $redis->select($settings['REDIS_DB']);

    return $redis;
};
