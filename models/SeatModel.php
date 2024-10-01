<?php

namespace app\models;

use app\core\DbModel;

class SeatModel extends DbModel
{
    public string $seat_id;
    public string $row;
    public string $number;
    public string $auditorium_id;

    //help for screening in movieReservationCustomer
    public string $screening_id;
    public string $price; //movie_price

    public array $allSeats;
    public array $reservedSeats;

    public function getSeats($screening_id): array
    {
        $sqlQuery = "SELECT s.`row`, group_concat(s.`number`) AS `number`
                    FROM seat s
                    INNER JOIN auditorium a ON s.auditorium_id = a.auditorium_id
                    INNER JOIN screening sg ON a.auditorium_id = sg.auditorium_id
                    WHERE
	                    sg.screening_id = '$screening_id'
                    GROUP by
	                    s.`row`";

        $dbData = $this->db->conn()->query($sqlQuery);

        $resultArray = [];

        while($result = $dbData->fetch_assoc()) {
            $resultArray[] = $result;
        }

        return $resultArray;
    }

    public function table(): string
    {
        return "seat";
    }

    public function attributes(): array
    {
        return [
            "row",
            "number",
            "auditorium_id"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}