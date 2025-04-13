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
    }

    // A setter for the Twig view
    public function setView(Twig $view): void {
        $this->view = $view;
    }

    public function setFlash($flash)
    {
      $this->flash = $flash;
    }

}
