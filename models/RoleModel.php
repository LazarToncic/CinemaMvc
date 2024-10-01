<?php

namespace app\models;

use app\core\DbModel;

class RoleModel extends DbModel
{
    public string $role_id;
    public string $name;
    public string $active;

    public function table(): string
    {
        return "role";
    }

    public function attributes(): array
    {
        return [
            "name",
            "active"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}