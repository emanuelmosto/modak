<?php

use Project\Controllers;
use Slim\Container;

/** @var Container $container */
$container = $app->getContainer();

$app->group('/api/v1', function () use ($app, $container) {
    $app->get(
        '/status',
        new Controllers\Status\ActionGetStatus($container)
    );
    $app->get(
        '/status/cache',
        new Controllers\Status\ActionGetCache($container)
    );
    $app->post(
        '/messages',
        new Controllers\Messages\ActionPostMessage($container)
    );
});
