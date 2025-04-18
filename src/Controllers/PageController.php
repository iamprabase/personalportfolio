<?php

namespace App\Controllers;

use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\PageModel;
use Slim\Csrf\Guard;

class PageController extends BaseController {
    private $pageModel;
    private static $config = null; // Holds the configuration

    public function __construct(Guard $csrf)
    {
        parent::__construct($csrf);
        $this->pageModel = new PageModel();
    }

    /**
     * Sets the configuration for the database connection.
     *
     * @param array $config The database configuration (host, dbname, user, pass, charset)
     */
    public static function setConfig(array $config): void {
        self::$config = $config;
    }

    // Display all pages (just for testing purposes)
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $pages = $this->pageModel->getAllPages();
        return $this->view->render($response, 'pages/index.twig', [
            'pages' => $pages,
        ]);
    }

    // Show a specific page by slug
    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $slug = $args['slug'];
        $page = $this->pageModel->getPageBySlug($slug);

        if ($page) {
            return $this->view->render($response, 'pages/show.twig', [
                'page' => $page,
            ]);
        }

        // Handle not found
        return $response->withStatus(404)->write('Page not found');
    }
}
