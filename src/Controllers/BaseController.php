<?php 
namespace App\Controllers;

use Slim\Views\Twig;
use Slim\Flash\Messages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseController {
    protected $view;
    protected Messages $flash;

    // A setter for the Twig view
    public function setView(Twig $view): void {
        $this->view = $view;
    }

    public function setFlash($flash)
    {
      $this->flash = $flash;
    }

}
