<?php
use Slim\App;

use App\Controllers\ArticleController;
use App\Controllers\AuthController;
use App\Controllers\CommentController;
use App\Controllers\AdminController;
use App\Controllers\PageController;

use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;

return function (App $app) {
    // Home page: list articles
    $app->get('/', [ArticleController::class, 'index']);
    // Article detail page, using slug for clean URL
    $app->get('/article/{slug}', [ArticleController::class, 'view']);

    // In routes/web.php or wherever your routes are defined
    $app->get('/change-language', function ($request, $response) {
        $params = $request->getQueryParams();
        $lang = $params['lang'] ?? 'en';

        // Validate language
        if (!in_array($lang, ['en', 'fr'])) {
            $lang = 'en';
        }

        // Set language in session
        $_SESSION['lang'] = $lang;

        // Redirect back (or to home if no referrer)
        $referer = $request->getServerParams()['HTTP_REFERER'] ?? '/';

        return $response
            ->withHeader('Location', $referer)
            ->withStatus(302);
    });

    // Authentication Routes
    $app->get('/login', [AuthController::class, 'showLogin']);
    $app->post('/login', [AuthController::class, 'login']);
    $app->get('/register', [AuthController::class, 'showRegister']);
    $app->post('/register', [AuthController::class, 'register']);

    // Page Routes
    $app->get('/pages', [PageController::class, 'index']);  // List all pages
    $app->get('/page/{slug}', [PageController::class, 'show']);  // Show a page by slug

    // Comment: Article Comments
    // Admin Routes (protected by AuthMiddleware)
    $app->group('', function ($group) {
      $group->get('/logout', [AuthController::class, 'logout']);
      $group->get('/update-profile', [AuthController::class, 'editProfile']);
      $group->post('/update-profile/{id}', [AuthController::class, 'updateProfile']);
      $group->post('/comments/{article_id}/store', [CommentController::class, 'store']);
      $group->post('/comments/{id}/update', [CommentController::class, 'update']);
      $group->post('/comments/{id}/delete', [CommentController::class, 'delete']);
    })->add(new AuthMiddleware());

    // Admin Routes (protected by AdminMiddleware)
    $app->group('/admin', function ($group) {
        $group->get('', [AdminController::class, 'dashboard']);
        $group->get('/articles', [AdminController::class, 'listArticles']);
        $group->get('/comments', [AdminController::class, 'listComments']);
        $group->get('/article/create', [AdminController::class, 'create']);
        $group->post('/article/create', [AdminController::class, 'store']);
        $group->get('/article/edit/{id}', [AdminController::class, 'edit']);
        $group->post('/article/edit/{id}', [AdminController::class, 'update']);
        $group->post('/article/delete/{id}', [AdminController::class, 'delete']);
    })->add(new AdminMiddleware());
};
