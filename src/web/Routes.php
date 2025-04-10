<?php
use Slim\App;
use App\Controllers\ArticleController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\PageController;
use App\Middleware\AdminMiddleware;


return function (App $app) {
    // Home page: list articles
    $app->get('/', [ArticleController::class, 'index']);
    // Article detail page, using slug for clean URL
    $app->get('/article/{slug}', [ArticleController::class, 'view']);

     // Authentication Routes
    $app->get('/login', [AuthController::class, 'showLogin']);
    $app->post('/login', [AuthController::class, 'login']);
    $app->get('/register', [AuthController::class, 'showRegister']);
    $app->post('/register', [AuthController::class, 'register']);
    $app->get('/logout', [AuthController::class, 'logout']);


    $app->get('/pages', PageController::class . ':index');  // List all pages
    $app->get('/page/{slug}', PageController::class . ':show');  // Show a page by slug

    
    // Admin Routes (protected by AuthMiddleware)
    $app->group('/admin', function ($group) {
        $group->get('', [AdminController::class, 'dashboard']);
        $group->get('/article/new', [AdminController::class, 'newArticle']);
        $group->post('/article/new', [AdminController::class, 'createArticle']);
        $group->get('/article/edit/{id}', [AdminController::class, 'editArticle']);
        $group->post('/article/edit/{id}', [AdminController::class, 'updateArticle']);
        $group->post('/article/delete/{id}', [AdminController::class, 'deleteArticle']);
        $group->get('/comments', [AdminController::class, 'manageComments']);
    })->add(new AdminMiddleware());
};
