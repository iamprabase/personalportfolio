<?php

namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Csrf\Guard;
use Slim\Views\Twig;

class CsrfMiddleware implements MiddlewareInterface
{
    protected $twig;
    protected $csrf;

    public function __construct(Guard $csrf, Twig $twig)
    {
        $this->twig = $twig;
        $this->csrf = $csrf;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->twig->getEnvironment()->addGlobal('csrf', [
            'token_name_key' => $this->csrf->getTokenNameKey(),
            'token_value_key' => $this->csrf->getTokenValueKey(),
            'token_name'     => $this->csrf->getTokenName(),
            'token_value'    => $this->csrf->getTokenValue(),
        ]);

        $this->csrf->setPersistentTokenMode(true);
        return $handler->handle($request);
    }
}
