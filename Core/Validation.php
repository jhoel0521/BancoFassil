<?php

namespace Core;

class Validation
{
    protected array $errors = [];

    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);

            foreach ($rulesArray as $rule) {
                $params = [];

                if (strpos($rule, ':') !== false) {
                    [$rule, $paramString] = explode(':', $rule);
                    $params = explode(',', $paramString);
                }

                $method = "validate" . ucfirst($rule);

                if (method_exists($this, $method)) {
                    $this->$method($field, $data[$field] ?? null, ...$params);
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    // 📌 Métodos de validación
    private function validateRequired(string $field, $value)
    {
        if (empty($value)) {
            $this->addError($field, "El campo $field es obligatorio.");
        }
    }

    private function validateEmail(string $field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "El campo $field debe ser un correo válido.");
        }
    }

    private function validateMin(string $field, $value, $minLength)
    {
        if (strlen($value) < $minLength) {
            $this->addError($field, "El campo $field debe tener al menos $minLength caracteres.");
        }
    }

    private function validateMax(string $field, $value, $maxLength)
    {
        if (strlen($value) > $maxLength) {
            $this->addError($field, "El campo $field no debe superar los $maxLength caracteres.");
        }
    }

    private function addError(string $field, string $message)
    {
        $this->errors[$field][] = $message;
    }
}
