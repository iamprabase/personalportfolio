<?php 
namespace App\Controllers;

use Slim\Views\Twig;
use Slim\Flash\Messages;
use Slim\Csrf\Guard;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseController {
    protected $view;
    protected Messages $flash;

    protected $csrf;

    public function __construct(Guard $csrf) {
        $this->csrf = $csrf;
        $this->view = Twig::create(__DIR__ . '/../../templates');
    }

    // A setter for the Twig view
    public function setView(Twig $view): void {
        $this->view = $view;
    }

    public function setFlash($flash)
    {
      $this->flash = $flash;
    }

    protected function createJsonBody(array $data): \Slim\Psr7\Stream {
      $stream = fopen('php://temp', 'r+');
      fwrite($stream, json_encode($data));
      rewind($stream);
      return new \Slim\Psr7\Stream($stream);
    }

    protected function addCsrfToView($request): void {
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
        $this->csrf->setPersistentTokenMode(true);


        $this->view->getEnvironment()->addGlobal('csrf', [
            'token_name_key' => $nameKey,
            'token_value_key' => $valueKey,
            'token_name'     => $name,
            'token_value'    => $value,
        ]);
    }

}
