<?php
// public/upload_image.php

// 1) Where on disk to save uploads:
$uploadDir = __DIR__ . '/uploads/article_featured_images/';

// 2) Make sure upload directory exists:
if (!is_dir($uploadDir)) {
  if (!mkdir($uploadDir, 0755, true)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create upload dir.']);
    exit;
  }
}

// 3) Ensure a file was sent:
if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['error' => 'No file uploaded or upload error.']);
  exit;
}

// 4) Move the uploaded file to our folder with a unique name:
$tmpPath = $_FILES['file']['tmp_name'];
$origName = basename($_FILES['file']['name']);
$ext = pathinfo($origName, PATHINFO_EXTENSION);
$newName = uniqid('img_', true) . '.' . $ext;
$destPath = $uploadDir . $newName;

if (!move_uploaded_file($tmpPath, $destPath)) {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to move uploaded file.']);
  exit;
}

// 5) Output the JSON TinyMCE expects:
echo json_encode([
  'location' => '/uploads/article_featured_images/' . $newName
]);
