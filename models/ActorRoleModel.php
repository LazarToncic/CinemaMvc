<?php

namespace app\models;

use app\core\DbModel;

class ActorRoleModel extends DbModel
{
    public $actor_role_id;
    public $movie_id;
    public $actor_id;
    public $played_role;

    public function table(): string
    {
        return "actor_role";
    }

    public function attributes(): array
    {
        return [
            "movie_id",
            "actor_id",
            "played_role"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}