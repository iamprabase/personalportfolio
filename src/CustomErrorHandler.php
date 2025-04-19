<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class CustomErrorHandler implements ErrorHandlerInterface
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(
        ServerRequestInterface $request,
        \Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $response = new Response();
        var_dump($exception->getMessage());
        die;

        return $this->twig->render($response->withStatus(500), 'errors/500.twig', [
            'message' => $displayErrorDetails ? $exception->getMessage() : 'An unexpected error occurred.'
        ]);
    }
}
