<?php

namespace app\models;

use app\core\DbConnection;
use app\core\DbModel;

class ActorModel extends DbModel
{
    public $actor_id;
    public $forename;
    public $surname;
    public $date_of_birth;

    public string $actors_full_name;
    public string $played_role; // za pomoc u funkciji insertActors

    public function insertActors(ActorModel $actorModel) {
        $db = new DbConnection();
        $movieModel = new MovieModel();

        if (strpos($actorModel->actors_full_name, ",")) {
            $actors = explode(",", $actorModel->actors_full_name);
        } else {
            $actors = [$actorModel->actors_full_name];
        }

        foreach ($actors as $actor) {
            $singleActor = explode("/", $actor);

            $provera = in_array("", $singleActor, true);

            if ($provera) {
                $singleActor = array_splice($singleActor, 1);
            }

            //var_dump($singleDirector);

            $sqlString = "
                SELECT *
                FROM actor
                WHERE
                    actor.forename = '$singleActor[0]' AND actor.surname = '$singleActor[1]' AND actor.date_of_birth = '$singleActor[2]';
            ";

            $dbData = $db->conn()->query($sqlString);

            $result = $dbData->fetch_assoc();

            if ($result !== null) {
                $actorModel->actor_id = $result["actor_id"];
                $actorModel->forename = $result["forename"];
                $actorModel->surname = $result["surname"];
                $actorModel->date_of_birth = $result["date_of_birth"];
            } else {
                $actorModel->forename = $singleActor[0];
                $actorModel->surname = $singleActor[1];
                $actorModel->date_of_birth = $singleActor[2];
                //var_dump($eachDirectorModel);
                $actorModel->create();

                $sqlStringForActorID = "
                    SELECT actor_id
                    FROM actor
                    WHERE
                        actor.forename = '$singleActor[0]' AND actor.surname = '$singleActor[1]' AND actor.date_of_birth = '$singleActor[2]';
                ";

                $dbActorID = $db->conn()->query($sqlStringForActorID);
                $idResult = $dbActorID->fetch_assoc();

                $actorModel->actor_id = $idResult["actor_id"];
            }

            $ActorRoleModel = new ActorRoleModel();

            $movieModel->mapData($movieModel->lastCreated());

            $ActorRoleModel->movie_id = $movieModel->movie_id;
            $ActorRoleModel->actor_id = $actorModel->actor_id;
            $ActorRoleModel->played_role = $singleActor[3];

            $singleActor = array();

            $ActorRoleModel->create();
        }
    }

    public function table(): string
    {
        return "actor";
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