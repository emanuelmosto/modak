<?php

namespace Project\Factories;

use Project\Entities\Rate;
use Project\Exceptions\FactoryException;
use stdClass;

class RateFactory
{
    const MISSING_ATTR_EXCEPTION = 'Missing %s attribute in data object';

    /**
     * The $dataObject must and stdClass instance object, and, at least
     * it needs to have the follow attributes: $hash, $metrics, $live
     *
     * @param stdClass $dataObject
     * @return Rate
     * @throws FactoryException
     */
    public static function createFromDataObject(stdClass $dataObject): Rate
    {
        self::validateDataObject($dataObject, [
            'rate',
            'unit',
            'currentTime'
        ]);

        return new Rate($dataObject->rate, $dataObject->unit, $dataObject->currentTime);
    }

    /**
     *
     * @param stdClass $dataObject
     * @param array $attributes
     * @throws FactoryException
     */
    protected static function validateDataObject(stdClass $dataObject, array $attributes): void
    {
        foreach ($attributes as $attr) {
            if (is_null($dataObject->$attr)) {
                $errorMessage = sprintf(self::MISSING_ATTR_EXCEPTION, $attr);
                $exception = new FactoryException();
                $exception->setMessage($errorMessage);

                throw $exception;
            }
        }
    }
}
