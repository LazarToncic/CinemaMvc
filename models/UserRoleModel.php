<?php

namespace app\models;

use app\core\DbModel;

class UserRoleModel extends DbModel
{
    public string $user_role_id;
    public string $user_id;
    public string $role_id;

    public function table(): string
    {
        return "user_role";
    }

    public function attributes(): array
    {
        return [
            "user_id",
            "role_id"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}