<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LanguageController {
    public function changeLanguage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $queryParams = $request->getQueryParams();
        $lang = $queryParams['lang'] ?? 'en'; // Default to 'en' if no language is provided

        // Validate the language (e.g., only allow 'en' and 'fr')
        if (!in_array($lang, ['en', 'fr'])) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        // Store the selected language in the session
        $_SESSION['lang'] = $lang;

        // Redirect back to the referring page or home page
        $referer = $request->getHeaderLine('Referer') ?: '/';
        return $response->withHeader('Location', $referer)->withStatus(302);
    }
}
