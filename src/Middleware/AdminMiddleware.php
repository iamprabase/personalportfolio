<?php 

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class AdminMiddleware {
    public function __invoke(Request $request, Handler $handler): Response {
        // Check if the user is logged in
        if (!isset($_SESSION['user'])) {
            // Redirect to login if not authenticated
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
        elseif(isset($_SESSION['user']) && !isset($_SESSION['user']['is_admin'])) {
            // Redirect to home if not an admin
            $response = new \Slim\Psr7\Response();
            // session_destroy();
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        // Proceed to the next middleware or route handler
        return $handler->handle($request);
    }
}
