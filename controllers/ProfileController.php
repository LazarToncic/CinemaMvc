<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\DbConnection;
use app\models\MovieModel;
use app\models\ProfileModel;

class ProfileController extends Controller
{

    public function userProfile() {
        $userEmail = Application::$app->session->get(Application::$app->session->USER_SESSION);

        if (!$userEmail) {
            header("location:" . "/home");
        }

        $sqlNameTotalPrice = "
            SELECT CONCAT(u.name, ' ', u.last_name) as user_name, SUM(r.total_price) AS user_total_price
            FROM user u
            INNER JOIN reservation r ON u.user_id = r.user_id
            WHERE email = '$userEmail'
            GROUP BY
	            u.user_id;
        ";

        $db = new DbConnection();

        $dbNameTotalPriceData = $db->conn()->query($sqlNameTotalPrice);
        $dbNameTotalPriceResult = $dbNameTotalPriceData->fetch_assoc();

        $profileModel = new ProfileModel();
        $profileModel->user_name = $dbNameTotalPriceResult["user_name"];
        $profileModel->total_price = $dbNameTotalPriceResult["user_total_price"];

        $sqlString = "
                    SELECT 
                        distinct(ri.movie_id)
                    FROM
                        reservation_item ri
                    INNER JOIN reservation r ON ri.reservation_id = r.reservation_id
                    INNER JOIN `user` u ON r.user_id = u.user_id
                    WHERE
                        u.email = '$userEmail'
        ";

        $dbEachMovie = $db->conn()->query($sqlString);

        while($result = $dbEachMovie->fetch_assoc()) {
            $movieModel = new MovieModel();
            $movieModel->movie_id = $result["movie_id"];

            $sqlEachMovie = "
                SELECT m.name, m.image_url
                FROM movie m
                WHERE movie_id = $movieModel->movie_id;
            ";

            $dbData = $db->conn()->query($sqlEachMovie);
            $dbData = $dbData->fetch_assoc();

            $movieModel->name = $dbData["name"];
            $movieModel->image_url = $dbData["image_url"];

            $profileModel->movies[] = $movieModel;

        }

        return $this->view("profile", "dashboard", $profileModel);
    }

    public function authorize(): array
    {
        return [];
    }
}