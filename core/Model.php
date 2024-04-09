<?php

namespace calamity\core;

class Model {
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_DATE_AFTER = 'date_after';
    public const RULE_DATE_BEFORE = 'date_before';
    public const RULE_PASSWORD = 'password';
    public const RULE_EXISTS = 'exists';
    public array $errors = [];

    public function loadData($data): void {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function attributes(): array {
        return [];
    }

    public function validate(): bool {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED and !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL and !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN and strlen($value) < $rule['min']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX and strlen($value) > $rule['max']) {
                    $this->addErrorByRule($attribute, self::RULE_MAX);
                }
                if ($ruleName === self::RULE_MATCH and $value !== $this->{$rule['match']}) {
                    $this->addErrorByRule($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_DATE_BEFORE and $value < $rule["date_before"]) {
                    $this->addErrorByRule($attribute, self::RULE_DATE_BEFORE, ['date_before' => $rule['date_before']]);
                }
                if ($ruleName === self::RULE_DATE_AFTER and $value > $rule["date_after"]) {
                    $this->addErrorByRule($attribute, self::RULE_DATE_BEFORE, ['date_after' => $rule['date_after']]);
                }
                if ($ruleName === self::RULE_PASSWORD and !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.{8,})((?=.*[-+_!@#$%^&*.,?])|(?=.*_))^[^ ]+$/', $value)) {
                    $this->addErrorByRule($attribute, self::RULE_PASSWORD);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $db = Calamity::$app->db;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record and $record->{$attribute} !== $value) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }
                if ($ruleName === self::RULE_EXISTS) {
                    $className = $rule['class'];
                    $tableName = $className::tableName();
                    $db = Calamity::$app->db;
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if (!$record) {
                        $this->addErrorByRule($attribute, self::RULE_EXISTS);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function rules(): array {
        return [];
    }

    protected function addErrorByRule(string $attribute, string $rule, $params = []): void {
        $params['field'] ??= $attribute;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $this->getLabel($value), $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }

    public function errorMessage($rule): string {
        return $this->errorMessages()[$rule];
    }

    public function errorMessages(): array {
        return [
            self::RULE_REQUIRED => Calamity::t('attributes', 'The field is required'),
            self::RULE_EMAIL => Calamity::t('attributes', 'The field has to be a valid email address'),
            self::RULE_MIN => Calamity::t('attributes', 'The field has to contains at least {min} characters'),
            self::RULE_MAX => Calamity::t('attributes', 'The field must contains a maximum of {max} characters'),
            self::RULE_MATCH => Calamity::t('attributes', 'The field has to match with {match}'),
            self::RULE_UNIQUE => Calamity::t('attributes', 'This field\'s value is used'),
            self::RULE_DATE_BEFORE => Calamity::t('attributes', 'The given date cannot be before {date_before}'),
            self::RULE_DATE_AFTER => Calamity::t('attributes', 'The given date cannot be after {date_before}'),
            self::RULE_PASSWORD => Calamity::t('attributes', 'Your password has to contain one uppercase, lowercase, number and special character'),
            self::RULE_EXISTS => Calamity::t('attributes', 'Please provide a value that exists'),
        ];
    }

    public function getLabel($attribute) {
        return static::labels()[$attribute] ?? $attribute;
    }

    public static function labels(): array {
        return [];
    }

    public function addError(string $attribute, string $message): void {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute): mixed {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute): mixed {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
}