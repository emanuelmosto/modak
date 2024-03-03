<?php

namespace Project\Controllers\Status;

use Project\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;

class ActionGetCache extends BaseController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {

        /* @var $cache \Redis */
        $cache = $this->container->get('cache');
        
        return $response->withJson(['ping' => $cache->ping()], 200);
    }
}
