<?php


use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Dotenv\Dotenv;
use DI\Container;
use Slim\Csrf\Guard;
// use App\Middleware\CsrfMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Start PHP session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Create Container and set settings
$container = new Container();

// Add Twig to container
$container->set('view', function () {
    $twig = Twig::create(__DIR__ . '/../templates', [
        'cache' => false, // or provide a cache dir in production
    ]);

    // Add flash messages globally
    if (isset($_SESSION['slimFlash'])) {
        $messages = $_SESSION['slimFlash'];
        $twig->getEnvironment()->addGlobal('flash', $messages);
        unset($_SESSION['slimFlash']);
    }

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
$responseFactory = $app->getResponseFactory();

// Register Middleware On Container
$container->set('csrf', function () use ($responseFactory) {
  
  $token_storage = null;

  return new Guard(
      $responseFactory,
      'csrf_token',
      $token_storage,
      null,
      200,
      16,
      true
  );
});

// Register Middleware To Be Executed On All Routes
$app->add('csrf');

// Load settings, routes, middleware, etc.
(require __DIR__ . '/../src/Settings.php')($container);

// Register Twig Middleware
$app->add(TwigMiddleware::createFromContainer($app));

(require __DIR__ . '/../src/web/Routes.php')($app);

$app->run();
