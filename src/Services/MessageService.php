<?php

namespace Project\Services;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class MessageService
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
     * Creates the CleanMessage from the parsed request body
     *
     * @param ServerRequestInterface $request
     * @return array|object|null
     */
    public function createFromRequest(ServerRequestInterface $request): object|array|null
    {
        $parsedBody = $request->getParsedBody();
        $this->logger->debug('MessageService: Incoming request: '
            . $request->getBody());

        return $parsedBody;
    }
}
