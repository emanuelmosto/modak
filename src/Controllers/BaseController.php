<?php

namespace Project\Controllers;

use Project\Services\MessageService;
use Project\Services\NotificationService;
use Project\Services\RateNotificationService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Log\LoggerInterface;
use Slim\Container;
use Slim\Http\Response;

class BaseController
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * BaseController constructor.
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @param $container
     * @return self
     */
    public function setContainer($container): static
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param Response $response
     * @param array $data
     * @param int $status
     *
     * @return Response
     */
    protected function withJson(Response $response, array $data, int $status = 200): Response
    {
        return $response->withJson($data, $status);
    }

    /**
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    protected function getMessageService(): MessageService
    {
        return $this->container->get('message_service');
    }

    /**
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    protected function getNotificationService(): NotificationService
    {
        return $this->container->get('notification_service');
    }

    /**
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    protected function getRateNotificationService(): RateNotificationService
    {
        return $this->container->get('rate_notification_service');
    }

    /**
     *
     * @return LoggerInterface
     * @throws ContainerExceptionInterface
     */
    protected function getLogger(): LoggerInterface
    {
        return $this->container->get('logger');
    }
}
