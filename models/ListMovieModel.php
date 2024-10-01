<?php

namespace app\models;

use app\core\DbModel;

class ListMovieModel extends DbModel
{
    public $movies;
    public $search;
    public $pageIndex;
    public $rowNumbers;

    public function getAllMovieNamesForReservation() {
        $dbResult = $this->db->conn()->query("
            SELECT m.name, m.movie_id
            FROM movie m
        ");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $movieModel = new MovieModel();
            $movieModel->mapData($result);
            $resultArray[] = $movieModel;
        }

        $this->movies = $resultArray;
    }

    public function search() {
        $dbResult = $this->db->conn()->query("
            select m.movie_id as 'movie_id', m.name as 'name', m.image_url as 'image_url', m.price as 'price', m.description as 'description', m.inCinema_at as 'pocetak_prikazivanja', c.category_id as 'category_id', GROUP_CONCAT(c.name) as category 
            from movie m 
            INNER JOIN movie_category mc on m.movie_id = mc.movie_id 
            inner join category c on mc.category_id = c.category_id
            WHERE m.name like '%$this->search%' or c.name like '%$this->search%'
            GROUP BY m.movie_id; 
        ");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $movieModel = new MovieModel();
            $movieModel->mapData($result);
            $resultArray[] = $movieModel;
        }

        $this->movies = $resultArray;

        return json_encode($this);
    }

    public function searchData() {
        /*$dbResult = $this->db->conn()->query("
            select m.movie_id as 'movie_id', m.name as 'name', m.image_url as 'image_url', m.price as 'price', m.description as 'description', c.category_id as 'category_id', c.name as 'category'
            from movie m
                
            inner join category c on m.category_id = c.category_id WHERE m.name like '%$this->search%' or c.name like '%$this->search%';
        ");*/

        $dbResult = $this->db->conn()->query("
            select m.movie_id as 'movie_id', m.name as 'name', m.image_url as 'image_url', m.price as 'price', m.description as 'description', c.category_id as 'category_id', GROUP_CONCAT(c.name) as category 
            from movie m 
            INNER JOIN movie_category mc on m.movie_id = mc.movie_id 
            inner join category c on mc.category_id = c.category_id
            WHERE m.most_popular = 1
            GROUP BY m.movie_id;
        ");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $movieModel = new MovieModel();
            $movieModel->mapData($result);
            $resultArray[] = $movieModel;
        }

        $this->movies = $resultArray;

        return $this;
    }

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