<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
class ImageController
{

  // Home page: list all articles
  public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $baseDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
    $imageData = [];

    try {
      // Scan the uploads directory for folders
      $directories = scandir($baseDir);
      foreach ($directories as $folder) {
        if ($folder === '.' || $folder === '..')
          continue;

        $folderPath = $baseDir . $folder;
        if (is_dir($folderPath)) {
          $images = [];

          $files = scandir($folderPath);
          foreach ($files as $file) {
            if ($file === '.' || $file === '..')
              continue;

            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath)) {
              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = [
                  'name' => $file,
                  'url' => '/public/uploads/' . $folder . '/' . $file,
                  'size' => filesize($filePath),
                  'modified' => filemtime($filePath)
                ];
              }
            }
          }

          if (!empty($images)) {
            usort($images, fn($a, $b) => $b['modified'] - $a['modified']);
          }

          $imageData[] = [
            'folder' => $folder,
            'images' => $images
          ];
        }
      }

      $response->getBody()->write(json_encode($imageData));
      return $response->withHeader('Content-Type', 'application/json');

    } catch (Exception $e) {
      $errorResponse = ['error' => $e->getMessage()];
      $response->getBody()->write(json_encode($errorResponse));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
  }

  public function folders(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $baseDir = dirname(__DIR__, 2) . '/public/uploads/';
    $folders = [];

    foreach (scandir($baseDir) as $folder) {
      if ($folder === '.' || $folder === '..')
        continue;
      if (is_dir($baseDir . $folder)) {
        $folders[] = $folder;
      }
    }

    $response->getBody()->write(json_encode($folders));
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function imagesInFolder(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $folder = basename($args['folder']); // Prevent path traversal
    $baseDir = dirname(__DIR__, 2) . '/public/uploads/' . $folder;

    $images = [];
    if (is_dir($baseDir)) {
      foreach (scandir($baseDir) as $file) {
        if ($file === '.' || $file === '..')
          continue;
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
          $images[] = [
            'name' => $file,
            'url' => '/uploads/' . $folder . '/' . $file
          ];
        }
      }
    }

    $response->getBody()->write(json_encode($images));
    return $response->withHeader('Content-Type', 'application/json');
  }

  // In ImageController.php
  public function uploadImage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    // Ensure the request is a POST request and contains files
    if ($request->getMethod() !== 'POST' || !$request->getUploadedFiles()) {
      $errorResponse = ['error' => 'No file uploaded or incorrect request type.'];
      $response->getBody()->write(json_encode($errorResponse));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Retrieve uploaded files
    $uploadedFiles = $request->getUploadedFiles();
    $uploadedFile = $uploadedFiles['image'] ?? null;

    // Check if the file is valid
    if (!$uploadedFile || $uploadedFile->getError() !== UPLOAD_ERR_OK) {
      $errorResponse = ['error' => 'Failed to upload image.'];
      $response->getBody()->write(json_encode($errorResponse));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

    // Define the upload directory
    $uploadDir = dirname(__DIR__, 2) . '/public/uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    // Generate a unique file name
    $fileName = uniqid() . '.' . pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    // Move the uploaded file to the uploads directory
    try {
      $uploadedFile->moveTo($filePath);

      // Return the file URL to the TinyMCE editor
      $responseData = [
        'url' => '/uploads/' . $fileName
      ];
      $response->getBody()->write(json_encode($responseData));
      return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
      $errorResponse = ['error' => 'Error moving uploaded file: ' . $e->getMessage()];
      $response->getBody()->write(json_encode($errorResponse));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
  }

}