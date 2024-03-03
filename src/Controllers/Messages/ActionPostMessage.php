<?php

namespace Project\Controllers\Messages;

use Psr\Container\ContainerExceptionInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Project\Controllers\BaseController;

class ActionPostMessage extends BaseController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $message = $this->getMessageService()->createFromRequest($request);

        $this->getLogger()->debug('ActionPostMessage: Message: ' . \json_encode($message['clean_text']));

        if ($this->getRateNotificationService()->handleRequest($message)) {
            $result = $this->getNotificationService()->SendMessage($message['clean_text']);
            return $response->withJson($result, 200);
        } else {
            return $response->withJson('Too many request', 429);
        }
    }
}
