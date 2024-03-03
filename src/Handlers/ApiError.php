<?php

namespace Project\Handlers;

use Exception;
use Project\Exceptions\BaseException;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\Error;
use Slim\Http\Response;

final class ApiError extends Error
{
    /** @var LoggerInterface */
    protected LoggerInterface $logger;

    /** @var \Raven_Client */
    protected $sentryClient;

    /** @var bool */
    protected bool $debug = false;

    /**
     * ApiError constructor.
     * @param LoggerInterface    $logger
     * @param \Raven_Client|null $sentryClient
     * @param bool $debug
     */
    public function __construct(
        LoggerInterface $logger,
        \Raven_Client $sentryClient = null,
        bool $debug = false
    ) {
        parent::__construct($logger);
        $this->logger = $logger;
        $this->sentryClient = $sentryClient;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface   $request
     * @param ResponseInterface        $response
     * @param Exception $exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Exception $exception
    )
    {
        if ($exception instanceof BaseException) {
            $status = $exception->getHttpCode();
            $data = $exception->toArray();
            $level = $exception->getLevel();
        } else {
            $status = 500;
            $data = [
                'class' => get_class($exception),
                'message' => $exception->getMessage(),
            ];
            $level = BaseException::ERROR;
        }
        $data['timestamp'] = time();

        $trace = $exception->getTrace();
        if (true === $this->debug) {
            $data['trace'] = $trace;
        }

        $previous = $exception->getPrevious();
        if (!empty($previous)) {
            $self = new ApiError(
                $this->logger,
                $this->sentryClient,
                $this->debug
            );
            $self->__invoke($request, $response, $previous);
        }

        $this->log(
            "{$data['timestamp']} {$data['message']}",
            $level,
            $trace
        );

        // Sentry Log Error
        if (!empty($this->sentryClient)) {
            $this->sentryLog($exception, $level);
        }

        /** @var Response $response */
        return $response->withJson($data, $status);
    }

    /**
     * @param string $message
     * @param string $level
     * @param array  $data
     */
    public function log($message, $level, $data = [])
    {
        if (!empty($this->logger)) {
            $level = strtolower($level);
            $this->logger->$level($message, $data);
        }
    }

    /**
     * @param Exception $exception
     * @param string     $level
     */
    public function sentryLog(Exception $exception, $level)
    {
        // This is necessary because Sentry doesn't have all the PSR7 levels
        // https://docs.sentry.io/clients/php/usage/ (search for "level")
        switch ($level) {
            case BaseException::ALERT:
            case BaseException::CRITICAL:
            case BaseException::EMERGENCY:
                $level = 'fatal';
                break;
            case BaseException::NOTICE:
                $level = 'warning';
                break;
        }

        $this->sentryClient->captureException($exception, ['level' => $level]);
    }
}
