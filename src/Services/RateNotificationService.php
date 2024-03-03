<?php

namespace Project\Services;

use Project\Entities\Rate;
use Project\Exceptions\RepositoryException;
use Project\Repositories\RateRepository;
use Psr\Log\LoggerInterface;

class RateNotificationService
{

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var RateRepository
     */
    protected RateRepository $rateRepository;

    public function __construct(LoggerInterface $logger, RateRepository $rateRepository)
    {
        $this->logger = $logger;
        $this->rateRepository = $rateRepository;
    }

    /**
     *
     * @param string $recipientId
     * @return Rate|null callback data object
     * @throws \RedisException
     */
    private function getNotificationRateByRecipient(string $recipientId): ?Rate
    {
        $callbackData = null;

        $result = $this->rateRepository->find($recipientId);
        if (!is_null($result)) {
            $callbackData = $result;
        }

        return $callbackData;
    }

    /**
     * @throws \RedisException
     * @throws RepositoryException
     */
    private function setNotificationRateByRecipient(array $message): Rate
    {
        $rate = new Rate($message['rate_limit']['rate'], $message['rate_limit']['unit'], microtime(true));

        $this->logger->debug('RateNotificationService: Set Rate: ' . print_r($message['recipient_id'], true));

        $this->rateRepository->persist($rate, $message['recipient_id']);

        return $rate;
    }


    /**
     * @throws \RedisException
     */
    private function updateNotificationRateByRecipient(array $message, $rate): void
    {
        $this->rateRepository->upDate($message['recipient_id'], $rate);
    }


    /**
     * @param array $message
     * @return Rate|string|null
     * @throws RepositoryException
     * @throws \RedisException
     */
    private function getRate(array $message): Rate|string|null
    {
        $rate = $this->getNotificationRateByRecipient($message['recipient_id']);
        if (empty($rate)) {
            $rate = $this->setNotificationRateByRecipient($message);
        }
        return $rate;
    }

    /**
     * Handle request Limit
     * @throws RepositoryException
     * @throws \RedisException
     */
    public function handleRequest(array $message): bool
    {

        $rate = $this->getRate($message);
        $elapsedTime = floor((microtime(true) - $rate->getCurrentTime()));

        if ($elapsedTime >= $rate->getRatesInSecond()) {
            $this->reNewRequestLimit($message, $rate);
            return true;
        }

        $rateConsumed = $rate->getRateNumber();
        if ($rateConsumed <= 1) {
            return false;
        }

        // Update redis and decrease the Request Limit
        $rate->updateRate($rate->getRateNumber() - 1);
        $this->updateNotificationRateByRecipient($message, $rate);

        return true;
    }

    /**
     * Renew Request Limit
     * @throws \RedisException
     */
    private function reNewRequestLimit($message, $rate): void
    {
        $currentTime = microtime(true);
        $rate->updateCurrentTime($currentTime);
        $rate->updateRate($message['rate_limit']['rate']);
        $this->updateNotificationRateByRecipient($message, $rate);
    }
}
