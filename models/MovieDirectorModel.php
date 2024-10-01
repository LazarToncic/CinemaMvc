<?php

namespace app\models;

use app\core\DbModel;

class MovieDirectorModel extends DbModel
{
    public $movie_director_id;
    public $movie_id;
    public $director_id;

    public function table(): string
    {
        return "movie_director";
    }

    public function attributes(): array
    {
        return [
            "movie_id",
            "director_id"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}