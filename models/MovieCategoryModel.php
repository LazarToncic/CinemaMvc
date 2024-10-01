<?php

namespace app\models;

use app\core\DbModel;

class MovieCategoryModel extends DbModel
{
    public string $movie_id;
    public string $category_id;

    public function table(): string
    {
        return "movie_category";
    }

    public function attributes(): array
    {
        return [
            "movie_id",
            "category_id"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}