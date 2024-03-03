<?php

declare(strict_types=1);

namespace Tests\Support;

use Codeception\Util\Stub;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Log\LoggerInterface;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

    /**
     * @see http://docs.guzzlephp.org/en/stable/testing.html#mock-handler
     *
     * @param array $responses
     * @return Client
     */
    public function mockHttpClient(array $responses)
    {
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    /**
     *
     * @return LoggerInterface;
     */
    public function mockLogger()
    {
        return \Codeception\Stub::makeEmpty(LoggerInterface::class);
    }
}
