<?php

//Services
use Project\Repositories\RateRepository;
use Project\Services\RateNotificationService;

$container['message_service'] = function ($container) {
    return new Project\Services\MessageService(
        $container->get('logger')
    );
};

$container['notification_service'] = function ($container) {
    return new Project\Services\NotificationService(
        $container->get('logger')
    );
};

$container['rate_notification_service'] = function ($container) {
    return new RateNotificationService(
        $container->get('logger'),
        $container->get('rate_repository')
    );
};

$container['rate_repository'] = function ($container) {
    return new RateRepository(
        $container->get('cache'),
        $container->get('settings')['cache.prefix']
    );
};

