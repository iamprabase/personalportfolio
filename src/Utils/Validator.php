<?php 

namespace App\Utils;

class Validator {
    protected $errors = [];

    public function validate(array $data, array $rules): bool {
        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            foreach (explode('|', $ruleSet) as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        return empty($this->errors);
    }

    protected function applyRule(string $field, $value, string $rule): void {
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = 'This field is required.';
        }

        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = 'Invalid email format.';
        }

        if (str_starts_with($rule, 'min:')) {
            $min = (int) explode(':', $rule)[1];
            if (strlen($value) < $min) {
                $this->errors[$field][] = "Must be at least $min characters.";
            }
        }

        if (str_starts_with($rule, 'max:')) {
            $max = (int) explode(':', $rule)[1];
            if (strlen($value) > $max) {
                $this->errors[$field][] = "Must not exceed $max characters.";
            }
        }

        if ($rule === 'alpha_num' && !ctype_alnum($value)) {
            $this->errors[$field][] = 'Must contain only letters and numbers.';
        }
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
