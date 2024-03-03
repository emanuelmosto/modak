<?php

namespace Project\Exceptions;

//use Project\BaseException;

class ServiceException extends BaseException
{
    /**
     * @var string
     */
    public $message = 'An error has occurred in this service';

    /**
     * @var string
     */
    public string $level = self::ERROR;

    /**
     * @var int
     */
    public int $httpCode = 500;

    /**
     * @var string
     */
    public $class = __CLASS__;
}
