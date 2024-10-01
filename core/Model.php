<?php

namespace app\core;

abstract class Model
{
    public const RULE_EMAIL = 'email';
    public const RULE_EMAIL_UNIQUE = 'emailUnique';
    public const RULE_REQUIRED = 'required';
    public const RULE_MATCH = 'match';

    public $errors;

    abstract public function rules(): array;

    public function validate() {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                if ($rule === self::RULE_REQUIRED && !$value) {
                    $this->addErrors($attribute, $rule);
                }

                if ($rule === self::RULE_EMAIL_UNIQUE && $this->emailUnique($value)) {
                    $this->addErrors($attribute, $rule);
                }

                if ($rule === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrors($attribute, $rule);
                }



                /*if ($rule === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorsWithParams($attribute, self::RULE_MATCH, $rule);
                }*/
            }
       }
    }

    public function addErrors($attribute, $rule) {
        $message = $this->errorMessage()[$rule];
        return $this->errors[$attribute][] = $message;
    }

    public function addErrorsWithParams($attribute, $rule, $params) {
        $message = $this->errorMessage()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{$key}", $value, $params);
        }

        return $this->errors[$attribute][] = $message;
    }

    public function errorMessage() {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This field must be valid email format",
            self::RULE_EMAIL_UNIQUE => "Email already exists",
            self::RULE_MATCH => "This filed must be same as {match}"
        ];
    }

    public function emailUnique($email): bool
    {
        $db = new DbConnection();
        $sqlString = "SELECT * FROM user WHERE email = '$email'";

        $dbResult = $db->conn()->query($sqlString);
        $dbResult = $dbResult->fetch_assoc();
        if ($dbResult !== null)
            return true;
        return false;
    }

    public function mapData($data) {
        if ($data !== null) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function mapDataWithArray($data) {
        if ($data !== null) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    if ($key == "singleMovieCategories") {
                        $this->{$key} = $value;
                    } else {
                        $this->{$key} = $value;
                    }
                }
            }
        }
    }
}