<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

class LanguageMiddleware
{
  public function __invoke(Request $request, Handler $handler): Response
  {
    $lang = $request->getQueryParams()['lang'] ?? $_SESSION['lang'] ?? 'fr';

    if (!in_array($lang, ['en', 'fr'])) {
      $lang = 'fr';
    }

    $_SESSION['lang'] = $lang;

    \App\Helpers\Translator::load();

    return $handler->handle($request);
  }
}
