<?php

use App\Middleware\CsrfMiddleware;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Flash\Messages;

return function ($container) {
    $container->set('settings', function () {
        return [
            'displayErrorDetails' => $_ENV['APP_DEBUG'], // Set to false in production
            // Add more settings as needed (e.g. DB credentials)
            'db' => [
                'host'     => $_ENV['DB_HOST'],
                'dbname'   => $_ENV['DB_NAME'],
                'user'     => $_ENV['DB_USER'],
                'pass'     => $_ENV['DB_PASS'],
                'port'     => $_ENV['DB_PORT'] ?? 3306,
                'charset'  => 'utf8mb4',
            ],
            'author_meta_info' => [
              'meta_title' => $_ENV['META_TITLE'], 
              'meta_description' => $_ENV['META_DESCRIPTION'],  
              'canonical_url' => $_ENV['CANONICAL_URL'], 
              'language' => $_ENV['LANGUAGE'], 
            ] 
        ];
    });

    $container->set(Guard::class, function() use ($container) {
      $app = \Slim\Factory\AppFactory::create(); // only for ResponseFactory
      $guard = new Guard($app->getResponseFactory());

      $guard->setFailureHandler(function ($request, $handler) use ($container) {
          $flash = $container->get(\Slim\Flash\Messages::class);
          $flash->addMessage('error', 'Invalid CSRF token, please try again.');
          $response = new \Slim\Psr7\Response();
          return $response
              ->withHeader('Location', '/')
              ->withStatus(302);
      });

      return $guard;
    });


    // Register CsrfMiddleware
    $container->set(CsrfMiddleware::class, function($container) {
        return new CsrfMiddleware(
            $container->get(Guard::class),
            $container->get('view')
        );
    });


    $container->set(Messages::class, function () {
      return new Messages();
    });

    // In your container configuration, set up the controller:
    $container->set(\App\Controllers\ArticleController::class, function($container) {
        $controller = new \App\Controllers\ArticleController();
        $controller->setView($container->get('view'));  // 'view' is registered as Twig in the container.
        $controller->setFlash($container->get(Messages::class));  
        return $controller;
    });

    // In your container configuration, set up the controller:
    $container->set(\App\Controllers\AdminController::class, function($container) {
        $controller = new \App\Controllers\AdminController();
        $controller->setView($container->get('view'));  // 'view' is registered as Twig in the container.
        $controller->setFlash($container->get(Messages::class));  
        return $controller;
    });

    // In your container configuration, set up the controller:
    $container->set(\App\Controllers\AuthController::class, function($container) {
        $controller = new \App\Controllers\AuthController();
        $controller->setView($container->get('view'));  // 'view' is registered as Twig in the container.
        $controller->setFlash($container->get(Messages::class));  
        return $controller;
    });

    // Retrieve the db settings from the container
    $settings = $container->get('settings');
    // Pass the db configuration array to your Database class.
    \App\Config\Database::setConfig($settings['db']);
    // Pass the configuration array to your Controller class.
    \App\Controllers\ArticleController::setConfig($settings['author_meta_info']);
};
