<?php

namespace app\models;

use app\core\DbModel;

class RegistrationModel extends DbModel
{
    public string $email;
    public string $password;
    public string $confirmPassword = "";
    public string $name;
    public string $last_name;
    public string $gender;
    public string $date_of_birth;

    public function register() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->create();

        $userModel = new UserModel();
        $roleModel = new RoleModel();
        $userRoleModel = new UserRoleModel();

        $userModel->mapData($userModel->one("email = '$this->email'"));
        $roleModel->mapData($roleModel->one("name = 'Customer'"));

        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = $roleModel->role_id;

        $userRoleModel->create();
    }

    public function table(): string
    {
        return "user";
    }

    public function attributes(): array
    {
        return [
            "email",
            "password",
            "name",
            "last_name",
            "gender",
            "date_of_birth"
        ];
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_EMAIL, self::RULE_REQUIRED, self::RULE_EMAIL_UNIQUE],
            "password" => [self::RULE_REQUIRED],
            "name" => [self::RULE_REQUIRED],
            "last_name" => [self::RULE_REQUIRED],
            "gender" => [self::RULE_REQUIRED],
            "date_of_birth" => [self::RULE_REQUIRED]
        ];
    }
}