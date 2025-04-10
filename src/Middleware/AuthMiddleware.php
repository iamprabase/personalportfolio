<?php 

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class AuthMiddleware {
    public function __invoke(Request $request, Handler $handler): Response {
        // Check if the user is logged in
        if (!isset($_SESSION['user'])) {
            // Redirect to login if not authenticated
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        // Proceed to the next middleware or route handler
        return $handler->handle($request);
    }
}
