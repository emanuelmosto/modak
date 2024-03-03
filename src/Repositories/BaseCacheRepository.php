<?php

namespace Project\Repositories;

use Redis;

abstract class BaseCacheRepository
{
    const DEFAULT_TIMEOUT = 86400;

    /**
     * @var Redis
     */
    protected Redis $cache;

    /**
     * @var string
     */
    protected string $prefix;

    /**
     *
     * @param Redis $cache
     * @param string $prefix
     */
    public function __construct(
        Redis $cache,
        string $prefix
    ) {
        $this->cache = $cache;
        $this->prefix = $prefix;
    }

    /**
     *
     * @param string $key
     * @return mixed|null
     * @throws \RedisException
     */
    protected function findByKey(string $key): mixed
    {
        $result = $this->cache->get($this->addPrefix($key));
        if ($result === false) {
            $result = null;
        }

        return $result;
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @param int $timeout default is 3600
     * @return boolean
     * @throws \RedisException
     */
    protected function save(
        string $key,
        mixed  $value,
        int $timeout = self::DEFAULT_TIMEOUT
    ): bool {
        return $this->cache->set($this->addPrefix($key), $value, $timeout);
    }

    /**
     *
     * @param string $key
     * @return boolean
     * @throws \RedisException
     */
    protected function delete(string $key): bool
    {
        return (bool)$this->cache->del($this->addPrefix($key));
    }

    /**
     *
     * @param string $key
     * @return string
     */
    protected function addPrefix(string $key): string
    {
        return sprintf(
            '%s:%s',
            $this->prefix,
            $key
        );
    }
}
