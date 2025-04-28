<?php
namespace App\Helpers;

class Translator
{
  private static $translations = [];

  public static function load()
  {
    $lang = $_SESSION['lang'] ?? 'fr';
    $file = __DIR__ . '/../lang/' . $lang . '.php';
    if (file_exists($file)) {
      self::$translations = include $file;
    }
  }

  public static function get(string $key): string
  {
    return self::$translations[$key] ?? $key;
  }
}
