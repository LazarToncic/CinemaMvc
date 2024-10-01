<?php

namespace app\models;

use app\core\DbModel;

class ScreeningModel extends DbModel
{
    public string $screening_id;
    public string $movie_id;
    public string $auditorium_id;
    public string $screening_start;

    public function table(): string
    {
        return "screening";
    }

    public function attributes(): array
    {
        return [
            "movie_id",
            "auditorium_id",
            "screening_start"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}