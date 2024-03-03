<?php

namespace Project\Exceptions;
class FactoryException extends BaseException
{
    /**
     * @var string
     */
    public $message = 'An error has occurred in this factory';

    /**
     * @var string
     */
    public string $level = parent::ERROR;

    /**
     * @var int
     */
    public int $httpCode = 500;

    /**
     * @var string
     */
    public $class = __CLASS__;
}
