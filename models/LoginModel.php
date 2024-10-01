<?php

namespace app\models;

use app\core\DbModel;

class LoginModel extends DbModel
{
    public string $email;
    public string $password;

    public function login(): bool
    {
        $resultFromDb = $this->one("email = '$this->email'"); // this->email mora u ''!!!!
        if ($resultFromDb != null) {
            return password_verify($this->password, $resultFromDb["password"]);
        }
        return false;
    }

    public function table(): string
    {
        return "user";
    }

    public function attributes(): array
    {
        return [
            "email",
            "password"
        ];
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_EMAIL, self::RULE_REQUIRED],
            "password" => [self::RULE_REQUIRED]
        ];
    }
}