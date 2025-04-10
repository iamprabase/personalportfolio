<?php

namespace App\Controllers;

use App\Models\PageModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageController extends BaseController {
    private $pageModel;

    public function __construct($view, PageModel $pageModel)
    {
        $this->view = $view;
        $this->pageModel = $pageModel;
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
