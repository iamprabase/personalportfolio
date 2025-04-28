<?php

namespace App\Utils;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\{
  HomeController,
  AuthController,
  CommentController,
  AdminController,
  PageController
};
use App\Middleware\{
  AdminMiddleware,
  AuthMiddleware
};

class RouteManager
{
  private App $app;

  public function __construct(App $app)
  {
    $this->app = $app;
  }

  /**
   * Register all application routes
   */
  public function registerRoutes(): void
  {
    $this->registerPublicRoutes();
    $this->registerAuthenticatedRoutes();
    $this->registerAdminRoutes();
  }

  /**
   * Register public routes
   */
  private function registerPublicRoutes(): void
  {
    $self = $this;
    $this->app->group('', function (RouteCollectorProxy $group) use ($self) {
      $routeManager = $self;
      // Home and Article Routes
      $routeManager->registerContentRoutes($group);
      // Authentication Routes
      $routeManager->registerAuthRoutes($group);
      // Language Switcher
      $routeManager->registerLanguageRoute($group);
    });
  }

  /**
   * Register content routes (home, articles, pages)
   */
  private function registerContentRoutes(RouteCollectorProxy $group): void
  {
    // Home page
    $group->get('/', [HomeController::class, 'index']);
    // Article detail page
    $group->get('/article/{slug}', [HomeController::class, 'view']);
    // Static pages
    $group->get('/page/{slug}', [PageController::class, 'show']);
  }

  /**
   * Register authentication routes
   */
  private function registerAuthRoutes(RouteCollectorProxy $group): void
  {
    $group->get('/login', [AuthController::class, 'showLogin']);
    $group->post('/login', [AuthController::class, 'login']);
    $group->get('/register', [AuthController::class, 'showRegister']);
    $group->post('/register', [AuthController::class, 'register']);
  }

  /**
   * Register language switching route
   */
  private function registerLanguageRoute(RouteCollectorProxy $group): void
  {
    $group->get('/change-language', function ($request, $response) {
      $params = $request->getQueryParams();
      $lang = $this->validateLanguage($params['lang'] ?? 'en');
      $_SESSION['lang'] = $lang;

      $referer = $request->getServerParams()['HTTP_REFERER'] ?? '/';
      return $response->withHeader('Location', $referer)
        ->withStatus(302);
    });
  }

  /**
   * Register authenticated user routes
   */
  private function registerAuthenticatedRoutes(): void
  {
    $self = $this;
    
    $this->app->group('', function (RouteCollectorProxy $group) use($self) {
      $routeManager = $self;
      // User Profile Routes
      $routeManager->registerProfileRoutes($group);

      // Comment Management Routes
      $routeManager->registerCommentRoutes($group);

      // Logout Route
      $group->get('/logout', [AuthController::class, 'logout']);
    })->add(new AuthMiddleware());
  }

  /**
   * Register user profile routes
   */
  private function registerProfileRoutes(RouteCollectorProxy $group): void
  {
    $group->get('/update-profile', [AuthController::class, 'editProfile']);
    $group->post('/update-profile/{id}', [AuthController::class, 'updateProfile']);
  }

  /**
   * Register comment management routes
   */
  private function registerCommentRoutes(RouteCollectorProxy $group): void
  {
    $group->post('/comments/{article_id}/store', [CommentController::class, 'store']);
    $group->post('/comments/{id}/update', [CommentController::class, 'update']);
    $group->post('/comments/{id}/delete', [CommentController::class, 'delete']);
  }

  /**
   * Register admin routes
   */
  private function registerAdminRoutes(): void
  {
    // Public admin routes
    $this->app->group('/admin', function (RouteCollectorProxy $group) {
      $group->get('/login', [AuthController::class, 'showAdminLogin']);
      $group->post('/login', [AuthController::class, 'adminLogin']);
      $group->get('/register', [AuthController::class, 'showAdminRegister']);
      $group->post('/register', [AuthController::class, 'adminRegister']);
    });


    $self = $this;
    // Protected admin routes
    $this->app->group('/admin', function (RouteCollectorProxy $group) use ($self) {
      // Dashboard
      $group->get('', [AdminController::class, 'dashboard']);
      $group->get('/users', [AdminController::class, 'dashboard']);

      $routeManager = $self;

      // Articles Management
      $routeManager->registerAdminArticleRoutes($group);

      // Pages Management
      $routeManager->registerAdminPageRoutes($group);

      // Comments Management
      $group->get('/comments', [AdminController::class, 'listComments']);
    })->add(new AdminMiddleware());
  }

  /**
   * Register admin article management routes
   */
  private function registerAdminArticleRoutes(RouteCollectorProxy $group): void
  {
    $group->get('/articles', [AdminController::class, 'listArticles']);
    $group->get('/article/create', [AdminController::class, 'create']);
    $group->post('/article/create', [AdminController::class, 'store']);
    $group->get('/article/edit/{id}', [AdminController::class, 'edit']);
    $group->post('/article/edit/{id}', [AdminController::class, 'update']);
    $group->post('/article/delete/{id}', [AdminController::class, 'delete']);
  }

  /**
   * Register admin page management routes
   */
  private function registerAdminPageRoutes(RouteCollectorProxy $group): void
  {
    $group->get('/pages', [AdminController::class, 'listPages']);
    $group->get('/pages/create', [AdminController::class, 'createPage']);
    $group->post('/pages/create', [AdminController::class, 'storePage']);
    $group->get('/page/edit/{id}', [AdminController::class, 'editPage']);
    $group->post('/page/edit/{id}', [AdminController::class, 'updatePage']);
    $group->post('/page/delete/{id}', [AdminController::class, 'deletePage']);
  }

  /**
   * Validate language selection
   */
  private function validateLanguage(string $lang): string
  {
    return in_array($lang, ['en', 'fr'], true) ? $lang : 'en';
  }
}