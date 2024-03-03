<?php

namespace Project\Controllers\Status;

use Project\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;

class ActionGetStatus extends BaseController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $time = time();
        return $response->withJson(['status' => 'OK', 'time' => $time], 200);
    }
}
