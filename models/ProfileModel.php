<?php

namespace app\models;

use app\core\DbModel;

class ProfileModel extends DbModel
{
    public string $user_name;
    public string $total_price;
    public array $movies;


    public function table(): string
    {
        return "user";
    }

    public function attributes(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }
}