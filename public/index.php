<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Dotenv\Dotenv;
use DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Start PHP session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Create Container and set settings
$container = new Container();

// Add CSRF Guard to the container
$container->set('csrf', function () use ($container) {
    $responseFactory = $container->get(ResponseFactoryInterface::class);
    return new Guard($responseFactory);
});

// Add ResponseFactoryInterface to the container
$container->set(ResponseFactoryInterface::class, function () {
    return AppFactory::determineResponseFactory();
});

// Add Twig to container
$container->set('view', function () {
    $twig = Twig::create(__DIR__ . '/../templates', [
        'cache' => false, // or provide a cache dir in production
    ]);

    // Add the `user` global variable to Twig before the environment is locked
    $twig->getEnvironment()->addGlobal('user', $_SESSION['user'] ?? null);

       // Add base_url function to Twig
    $twig->getEnvironment()->addFunction(new \Twig\TwigFunction('base_url', function () {
        return rtrim((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'], '/');
    }));

    return $twig;
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->add('csrf');

// Pass CSRF token to Twig
$app->add(function ($request, $handler) use ($container) {
    $csrf = $container->get('csrf');
    $container->get('view')->getEnvironment()->addGlobal('csrf_token', $csrf->getTokenNameKey());
    $container->get('view')->getEnvironment()->addGlobal('csrf_value', $csrf->getTokenValueKey());
    return $handler->handle($request);
});

// Register Twig Middleware
$app->add(TwigMiddleware::createFromContainer($app));

// Load settings, routes, middleware, etc.
(require __DIR__ . '/../src/Settings.php')($container);
(require __DIR__ . '/../src/web/Routes.php')($app);

$app->run();
