<?php

$container = $app->getContainer();

$container["errorHandler"] = function ($container) {
    return new Project\Handlers\ApiError(
        $container["logger"],
        $container["sentry"],
        $container['settings']['DEBUG']
    );
};
