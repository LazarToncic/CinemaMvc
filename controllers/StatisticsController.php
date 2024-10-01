<?php

namespace app\controllers;

use app\core\Controller;
use app\core\DbConnection;
use app\models\ReservationModel;

class StatisticsController extends Controller
{

    public function orders() {
        $priceFrom = $this->router->request->one("priceFrom");
        $priceTo = $this->router->request->one("priceTo");
        $dateFrom = $this->router->request->one("dateFrom");
        $dateTo = $this->router->request->one("dateTo");

        $reservationModel = new ReservationModel();
        $dbData = $reservationModel->orders($priceFrom, $priceTo, $dateFrom, $dateTo);


        echo json_encode($dbData);
    }

    public function ordersTop10() {
        $db = new DbConnection();
        $top10From = $this->router->request->one("top10From");
        $top10To = $this->router->request->one("top10To");

        $top10From = $top10From == "" ? 1 : $top10From;
        $top10To = $top10To == "" ? 100000 : $top10To;


//        $sqlString = "SELECT sum(total_price) as `total_price`, u.email FROM reservation r
//                      inner join user u on r.user_id = u.user_id
//                      WHERE total_price > $top10From AND total_price < $top10To
//                      GROUP BY r.user_id;";

        $sqlString = "WITH cte1 AS (SELECT sum(total_price) as total_price, u.email, r.data_created FROM reservation r inner join user u on r.user_id = u.user_id GROUP BY r.user_id) 
        SELECT total_price, email, data_created FROM cte1 WHERE total_price > $top10From AND total_price < $top10To AND data_created between (NOW() - INTERVAL 3 MONTH) AND NOW() ORDER BY total_price DESC LIMIT 10;";

        $dbResult = $db->conn()->query($sqlString);

        $resultArray = [];

        while($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        //var_dump($resultArray);
        echo json_encode($resultArray);
    }

    public function movieTopQuantity() {
        $db = new DbConnection();
        $movieTopQuantityFrom = $this->router->request->one("movieTopQuantityFrom");
        $movieTopQuantityTo = $this->router->request->one("movieTopQuantityTo");

        $movieTopQuantityFrom = $movieTopQuantityFrom == "" ? 0 : $movieTopQuantityFrom;
        $movieTopQuantityTo = $movieTopQuantityTo == "" ? 100000 : $movieTopQuantityTo;

        /*$sqlString = "SELECT sum(ri.quantity) as `quantity`, m.name FROM reservation_item ri
                      inner join movie m on ri.movie_id = m.movie_id
                      WHERE quantity > $movieTopQuantityFrom AND quantity < $movieTopQuantityTo
                      GROUP BY ri.movie_id;";*/

        $sqlString = "WITH cte1 AS (SELECT sum(ri.quantity) as quantity, m.name FROM reservation_item ri inner join movie m on ri.movie_id = m.movie_id GROUP BY ri.movie_id) SELECT quantity, name FROM cte1 WHERE quantity > $movieTopQuantityFrom AND quantity < $movieTopQuantityTo;";

        $dbResult = $db->conn()->query($sqlString);

        $resultArray = [];

        while($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        //var_dump($resultArray);
        echo json_encode($resultArray);
    }

    public function authorize(): array
    {
        return [
            "Admin",
            "SuperAdmin"
        ];
    }
}