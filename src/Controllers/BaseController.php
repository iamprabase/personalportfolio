<?php 
namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseController {
    protected $view;

    // A setter for the Twig view
    public function setView(Twig $view): void {
        $this->view = $view;
    }

    // Optionally, you can add common methods here that all controllers might use
}
