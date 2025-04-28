<?php
namespace App\Utils;

use Psr\Http\Message\UploadedFileInterface;

class Validator
{
  private array $errors = [];
  private array $data = [];
  private array $customMessages = [];

  /**
   * Validation rules with their corresponding methods
   */
  private const VALIDATION_RULES = [
    'required' => 'validateRequired',
    'email' => 'validateEmail',
    'alpha_num' => 'validateAlphaNum',
    'min' => 'validateMin',
    'max' => 'validateMax',
    'same' => 'validateSame',
    'file' => 'validateFile',
    'mimes' => 'validateMimes',
    'size' => 'validateFileSize'
  ];

  /**
   * Default error messages
   */
  private const DEFAULT_MESSAGES = [
    'required' => 'This field is required.',
    'email' => 'This field must be a valid email address.',
    'alpha_num' => 'This field must contain only letters and numbers.',
    'min' => 'This field must be at least :min characters.',
    'max' => 'This field must not exceed :max characters.',
    'same' => 'This field must match :other.',
    'file' => 'File upload error.',
    'mimes' => 'Invalid file type. Only :allowed are allowed.',
    'size' => 'File size exceeds the maximum limit of :size.'
  ];

  /**
   * Validate input data against rules
   */
  public function validate(array $data, array $rules, array $messages = []): bool
  {
    $this->data = $data;
    $this->customMessages = $messages;
    $this->errors = [];

    foreach ($rules as $field => $ruleSet) {
      $this->validateField($field, $ruleSet);
    }

    return empty($this->errors);
  }

  /**
   * Validate a single field
   */
  private function validateField(string $field, string $ruleSet): void
  {
    $value = $this->data[$field] ?? null;
    $rules = explode('|', $ruleSet);

    foreach ($rules as $rule) {
      $this->processRule($field, $value, $rule);
    }
  }

  /**
   * Process individual validation rule
   */
  private function processRule(string $field, $value, string $rule): void
  {
    $parameters = [];

    if (str_contains($rule, ':')) {
      [$rule, $parameter] = explode(':', $rule, 2);
      $parameters = explode(',', $parameter);
    }

    if (isset(self::VALIDATION_RULES[$rule])) {
      $method = self::VALIDATION_RULES[$rule];
      $this->$method($field, $value, $parameters);
    }
  }

  /**
   * Validate required fields
   */
  private function validateRequired(string $field, $value, array $parameters = []): void
  {
    if (is_null($value) || $value === '') {
      $this->addError($field, 'required');
    }
  }

  /**
   * Validate email format
   */
  private function validateEmail(string $field, $value, array $parameters = []): void
  {
    if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->addError($field, 'email');
    }
  }

  /**
   * Validate alphanumeric input
   */
  private function validateAlphaNum(string $field, $value, array $parameters = []): void
  {
    if ($value && !ctype_alnum($value)) {
      $this->addError($field, 'alpha_num');
    }
  }

  /**
   * Validate minimum length
   */
  private function validateMin(string $field, $value, array $parameters = []): void
  {
    $min = (int) ($parameters[0] ?? 0);
    if ($value && strlen($value) < $min) {
      $this->addError($field, 'min', ['min' => $min]);
    }
  }

  /**
   * Validate maximum length
   */
  private function validateMax(string $field, $value, array $parameters = []): void
  {
    $max = (int) ($parameters[0] ?? 0);
    if ($value && strlen($value) > $max) {
      $this->addError($field, 'max', ['max' => $max]);
    }
  }

  /**
   * Validate field matches another field
   */
  private function validateSame(string $field, $value, array $parameters = []): void
  {
    $otherField = $parameters[0] ?? '';
    if ($value !== ($this->data[$otherField] ?? null)) {
      $this->addError($field, 'same', ['other' => $otherField]);
    }
  }

  /**
   * Validate file upload
   */
  private function validateFile(string $field, $value, array $parameters = []): void
  {
    if ($value instanceof UploadedFileInterface && $value->getError() !== UPLOAD_ERR_OK) {
      $this->addError($field, 'file');
    }
  }

  /**
   * Validate file mime types
   */
  private function validateMimes(string $field, $value, array $parameters = []): void
  {
    if ($value instanceof UploadedFileInterface) {
      $mimeType = $value->getClientMediaType();
      $allowedTypes = array_map(
        fn($type) => 'image/' . $type,
        $parameters
      );

      if (!in_array($mimeType, $allowedTypes)) {
        $this->addError($field, 'mimes', ['allowed' => implode(', ', $parameters)]);
      }
    }
  }

  /**
   * Validate file size
   */
  private function validateFileSize(string $field, $value, array $parameters = []): void
  {
    if ($value instanceof UploadedFileInterface) {
      $maxSize = (int) ($parameters[0] ?? 0) * 1024; // Convert KB to bytes
      if ($value->getSize() > $maxSize) {
        $this->addError($field, 'size', ['size' => $parameters[0] . 'KB']);
      }
    }
  }

  /**
   * Add validation error
   */
  private function addError(string $field, string $rule, array $parameters = []): void
  {
    $message = $this->customMessages["$field.$rule"]
      ?? $this->customMessages[$rule]
      ?? self::DEFAULT_MESSAGES[$rule];

    foreach ($parameters as $key => $value) {
      $message = str_replace(":$key", $value, $message);
    }

    $this->errors[$field][] = $message;
  }

  /**
   * Get validation errors
   */
  public function getErrors(): array
  {
    return $this->errors;
  }

  /**
   * Check if field has errors
   */
  public function hasError(string $field): bool
  {
    return isset($this->errors[$field]);
  }

  /**
   * Get first error for field
   */
  public function getFirstError(string $field): ?string
  {
    return $this->errors[$field][0] ?? null;
  }
}
