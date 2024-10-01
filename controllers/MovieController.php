<?php

namespace app\controllers;

use app\core\Controller;
use app\core\DbConnection;
use app\models\ListMovieModel;
use app\models\MovieModel;

class MovieController extends Controller
{
    public function movies() {
        $this->view("movies", "dashboard", null);
    }

    public function getMovieRows() {
        $listMovieModel = new ListMovieModel();
        $listMovieModel->mapData($this->router->request->all());

        echo $listMovieModel->search();
    }

    public function movieDetails() {
        $movieModel = new MovieModel();
        $db = new DbConnection();
        $movieModel->mapData($this->router->request->all());

        $sqlString = "
            SELECT m.name, m.image_url, m.price, m.description, m.inCinema_at as pocetak_prikazivanja,m.movie_length, GROUP_CONCAT(DISTINCT(c.name)) as category, 
                   GROUP_CONCAT(DISTINCT(CONCAT(d.forename, ' ', d.surname))) as director_name,
                   GROUP_CONCAT(DISTINCT(CONCAT(CONCAT(a.forename, ' ', a.surname), ' as ', ar.played_role))) as actor_name_role,
                    GROUP_CONCAT(DISTINCT(CONCAT(s.screening_start, '/', am.auditorium_name)) SEPARATOR ', ') AS time_auditorium,   
                    group_concat(distinct(s.screening_id)) as screening_id,
                    m.price
            FROM movie m
            INNER JOIN movie_category mc on m.movie_id = mc.movie_id
            INNER JOIN category c on mc.category_id = c.category_id
            INNER JOIN movie_director md on m.movie_id = md.movie_id
            INNER JOIN director d on md.director_id = d.director_id
            inner join actor_role ar on m.movie_id = ar.movie_id
            INNER JOIN actor a on ar.actor_id = a.actor_id
            INNER JOIN screening s ON m.movie_id = s.movie_id
            INNER JOIN auditorium am ON s.auditorium_id = am.auditorium_id
            WHERE
                m.movie_id = '$movieModel->movie_id'
            GROUP BY
                m.movie_id;
        ";

        $dbData = $db->conn()->query($sqlString);
        $dbData = $dbData->fetch_assoc();
/*
        var_dump($dbData);
        exit;
*/
        $movieModel->mapData($dbData);

        return $this->view("movieDetails", "dashboard", $movieModel);
    }

    public function getMovieRowsHome() {
        $listMovieModel = new ListMovieModel();
        $listMovieModel->mapData($this->router->request->all());

        $listMovieModel->searchData();

        echo $this->partialView("homeRows", $listMovieModel);
    }

    public function authorize(): array
    {
        return [];
    }
}