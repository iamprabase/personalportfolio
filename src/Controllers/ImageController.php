<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
class ImageController
{

  // Home page: list all articles
  public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {

    // Correct path construction with proper directory separator
    $uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'article_featured_images' . DIRECTORY_SEPARATOR;
    $images = [];

    // Check if directory exists and create if it doesn't
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    try {
      // Scan directory for images
      if (is_dir($uploadDir)) {
        $files = scandir($uploadDir);
        if ($files !== false) {
          foreach ($files as $file) {
            // Skip . and .. directories
            if ($file === '.' || $file === '..') {
              continue;
            }

            $filePath = $uploadDir . $file;
            if (is_file($filePath)) {
              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = [
                  'name' => $file,
                  'url' => '/public/uploads/article_featured_images/' . $file,
                  'size' => filesize($filePath),
                  'modified' => filemtime($filePath)
                ];
              }
            }
          }

          // Sort by most recent
          if (!empty($images)) {
            usort($images, function ($a, $b) {
              return $b['modified'] - $a['modified'];
            });
          }
        }
      }

      // Write to response body and return response
      $response->getBody()->write(json_encode($images));
      return $response->withHeader('Content-Type', 'application/json');

    } catch (Exception $e) {
      // Handle errors by returning error response
      $errorResponse = ['error' => $e->getMessage()];
      $response->getBody()->write(json_encode($errorResponse));
      return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(500);
    }
  }
}