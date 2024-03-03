<?php

namespace Project\Repositories;

use Project\Entities\Rate;
use Project\Exceptions\FactoryException;
use Project\Exceptions\RepositoryException;
use Project\Factories\RateFactory;

class RateRepository extends BaseCacheRepository
{
    const PREFIX = 'rate';
    const SAVE_ERROR = 'An error has occurred trying to persist the rate limit';

    /**
     *
     * @param string $hash
     * @return Rate|null
     * @throws FactoryException
     * @throws \RedisException
     */
    public function find(string $hash): Rate|null
    {
        $key = $this->getKey($hash);
        $storedRecipient = parent::findByKey($key);

        $dataObject = null;
        if (!is_null($storedRecipient)) {
            $dataObject = \json_decode($storedRecipient);
            $dataObject = RateFactory::createFromDataObject($dataObject);
        }

        return $dataObject;
    }

    /**
     *
     * @param Rate $rate
     * @param string $recipientId
     * @return boolean
     * @throws RepositoryException
     * @throws \RedisException
     */
    public function persist(Rate $rate, string $recipientId): bool
    {
        $key = $this->getKey($recipientId);
        $result = parent::save($key, json_encode($rate));

        if ($result === false) {
            $exception = new RepositoryException();
            $exception->setMessage(self::SAVE_ERROR);

            throw $exception;
        }

        return $result;
    }

    /**
     *
     * @param string $hash
     * @return boolean
     * @throws \RedisException
     */
    public function remove(string $hash): bool
    {
        $key = $this->getKey($hash);

        return parent::delete($key);
    }

    /**
     * @throws \RedisException
     */
    public function upDate(string $hash, $rate): void
    {
        $key = $this->getKey($hash);
        $this->remove($key);
        parent::save($key, json_encode($rate));
    }



    /**
     *
     * @param string $hash
     * @return string
     */
    protected function getKey(string $hash): string
    {
        return sprintf('%s:%s', self::PREFIX, $hash);
    }
}
