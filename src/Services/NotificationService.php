<?php

namespace Project\Services;

use Project\Interfaces\NotificationServiceInterface;
use Psr\Log\LoggerInterface;

class NotificationService implements NotificationServiceInterface
{

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Send Notification Message
     *
     * @param String $message
     * @return string
     */
    public function sendMessage(String $message): string
    {
        $this->logger->info('NotificationService: Sending Message: ' . $message);

        return "Message Sent";
    }
}
