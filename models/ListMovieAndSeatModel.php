<?php

namespace app\models;

use app\core\DbModel;

class ListMovieAndSeatModel extends DbModel
{
    public ListMovieModel $listMovieModel;
    public SeatModel $seatModel;

    public function table(): string
    {
        return "";
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