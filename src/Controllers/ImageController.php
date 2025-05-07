<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
class ImageController
{

  public function uploadImages(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $uploadedFiles = $request->getUploadedFiles();
    $parsedBody = $request->getParsedBody();
    $folder = basename($parsedBody['folder'] ?? '');

    if (empty($folder)) {
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
        ->write(json_encode(['error' => 'Folder name required.']));
    }

    $image = $uploadedFiles['image'] ?? null;
    if (!$image || $image->getError() !== UPLOAD_ERR_OK) {
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
        ->write(json_encode(['error' => 'Invalid image upload.']));
    }

    // Ensure upload path exists
    $uploadDir = dirname(__DIR__, 2) . '/public/uploads/' . $folder;
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Generate safe and unique filename
    $extension = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
    $safeName = bin2hex(random_bytes(10)) . '.' . $extension;
    $destination = $uploadDir . '/' . $safeName;

    try {
      $image->moveTo($destination);
    } catch (\RuntimeException $e) {
      return $response->withStatus(500)->withHeader('Content-Type', 'application/json')
        ->write(json_encode(['error' => 'Error moving uploaded file: ' . $e->getMessage()]));
    }

    // Construct URL to return
    $publicUrl = "/uploads/{$folder}/{$safeName}";
    $response->getBody()->write(json_encode([
      'status' => 'success',
      'url' => $publicUrl,
      'name' => $safeName
    ]));
    return $response->withHeader('Content-Type', 'application/json');
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
    $uri = $request->getUri();

    $scheme = $uri->getScheme();              // http or https
    $host = $uri->getHost();                  // e.g., localhost or domain.com
    $port = $uri->getPort();                  // optional: 8080, etc.
    $basePath = $request->getUri()->getPath(); // gives full path (optional)

    $baseUrl = $scheme . '://' . $host . ($port ? ':' . $port : '');

    // Final uploads URL:
    $uploadDir = $baseUrl . '/uploads/';
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