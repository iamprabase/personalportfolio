<?php 

namespace App\Utils;

class Validator {
    protected $errors = [];
    protected $data = []; // Add a property to store the data being validated

    public function validate(array $data, array $rules): bool {
        $this->data = $data; // Store the data for use in validation rules

        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            foreach (explode('|', $ruleSet) as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    public function applyRule(string $field, $value, string $rule): void {
        // Handle file-specific validation
        if ($value instanceof \Psr\Http\Message\UploadedFileInterface) {
            if ($rule === 'file') {
                if ($value->getError() !== UPLOAD_ERR_OK) {
                    $this->addError($field, 'File upload error.');
                }
            }

            if (str_starts_with($rule, 'mimes:')) {
                $allowedMimes = explode(',', str_replace('mimes:', '', $rule));
                if (!in_array($value->getClientMediaType(), $allowedMimes)) {
                    $this->addError($field, 'Invalid file type. Only png, jpg, jpeg are allowed with maximum upload size of 2MB.');
                }
            }

            if (str_starts_with($rule, 'max:')) {
                $maxSize = (int) str_replace('max:', '', $rule) * 1024; // Convert KB to bytes
                if ($value->getSize() > $maxSize) {
                    $this->addError($field, 'File size exceeds the maximum limit.');
                }
            }

            return; // Skip further validation for file inputs
        }

        // Handle non-file validation rules
        if ($rule === 'required' && (is_null($value) || $value === '')) {
            $this->addError($field, 'This field is required.');
        }

        if ($rule === 'alpha_num' && !ctype_alnum($value)) {
            $this->addError($field, 'This field must contain only letters and numbers.');
        }

        if (str_starts_with($rule, 'min:')) {
            $min = (int) str_replace('min:', '', $rule);
            if (strlen($value) < $min) {
                $this->addError($field, "This field must be at least $min characters.");
            }
        }

        if (str_starts_with($rule, 'max:')) {
            $max = (int) str_replace('max:', '', $rule);
            if (strlen($value) > $max) {
                $this->addError($field, "This field must not exceed $max characters.");
            }
        }

        if (str_starts_with($rule, 'same:')) {
            $otherField = str_replace('same:', '', $rule);
            if ($value !== ($this->data[$otherField] ?? null)) {
                $this->addError($field, "This field must match $otherField.");
            }
        }

        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'This field must be a valid email address.');
        }
    }

    public function getErrors(): array {
        return $this->errors;
    }

    protected function addError(string $field, string $message): void {
        $this->errors[$field][] = $message;
    }
}
