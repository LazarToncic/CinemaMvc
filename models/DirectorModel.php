<?php

namespace app\models;

use app\core\DbConnection;
use app\core\DbModel;

class DirectorModel extends DbModel
{
    public $director_id;
    public $forename;
    public $surname;
    public $date_of_birth;

    public string $directors_full_name;

    public function insertDirectors(DirectorModel $directorModel) {
        //FOR DIRECTORS

        $db = new DbConnection();
        $movieModel = new MovieModel();

        if (strpos($directorModel->directors_full_name, ",")) {
            $directors = explode(",", $directorModel->directors_full_name);
        } else {
            $directors = [$directorModel->directors_full_name];
        }

        foreach ($directors as $director) {
            $singleDirector = explode(" ", $director);

            $provera = in_array("", $singleDirector, true);

            if ($provera) {
                $singleDirector = array_splice($singleDirector, 1);
            }

            //var_dump($singleDirector);

            $sqlString = "
                SELECT *
                FROM director
                WHERE
                    director.forename = '$singleDirector[0]' AND director.surname = '$singleDirector[1]' AND director.date_of_birth = '$singleDirector[2]';
            ";

            $dbData = $db->conn()->query($sqlString);

            $result = $dbData->fetch_assoc();

            if ($result !== null) {
                $directorModel->director_id = $result["director_id"];
                $directorModel->forename = $result["forename"];
                $directorModel->surname = $result["surname"];
                $directorModel->date_of_birth = $result["date_of_birth"];
            } else {
                $directorModel->forename = $singleDirector[0];
                $directorModel->surname = $singleDirector[1];
                $directorModel->date_of_birth = $singleDirector[2];
                //var_dump($eachDirectorModel);
                $directorModel->create();

                $sqlStringForDirectorID = "
                    SELECT director_id
                    FROM director
                    WHERE
                        director.forename = '$singleDirector[0]' AND director.surname = '$singleDirector[1]' AND director.date_of_birth = '$singleDirector[2]';
                ";

                $dbDirectorID = $db->conn()->query($sqlStringForDirectorID);
                $idResult = $dbDirectorID->fetch_assoc();

                $directorModel->director_id = $idResult["director_id"];
            }
            $singleDirector = array();

            $movieDirectorModel = new MovieDirectorModel();

            $movieModel->mapData($movieModel->lastCreated());

            $movieDirectorModel->movie_id = $movieModel->movie_id;
            $movieDirectorModel->director_id = $directorModel->director_id;

            $movieDirectorModel->create();
        }
    }

    public function table(): string
    {
        return "director";
    }

    public function attributes(): array
    {
        return [
            "forename",
            "surname",
            "date_of_birth"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}