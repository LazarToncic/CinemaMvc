<?php

namespace app\models;

use app\core\DbModel;

class SeatReservedModel extends DbModel
{
    public string $seat_reserved_id;
    public string $seat_id;
    public string $reservation_id;
    public string $screening_id;

    public string $reserved_seats;

    public function getReservedSeats($screening_id): array
    {
        $sqlQueryForSeatIds = "
            SELECT sr.seat_id
            FROM seat_reserved sr
            INNER JOIN seat s on sr.seat_id = s.seat_id
            INNER JOIN screening scr on sr.screening_id = scr.screening_id
            WHERE
                scr.screening_id = '$screening_id';   
        ";

        $dbDataForSeatIds = $this->db->conn()->query($sqlQueryForSeatIds);
        $resultForSeatIds = [];

        while ($result = $dbDataForSeatIds->fetch_assoc()) {
            $resultForSeatIds[] = $result["seat_id"];
        }

        $reservedSeatNumbers = [];

        foreach ($resultForSeatIds as $resultForSeatId) {
            $sqlQuerySeatNumbers = "
                SELECT s.number
                FROM seat s
                WHERE
                    s.seat_id = '$resultForSeatId';
            ";

            $dbDataSeatNumbers = $this->db->conn()->query($sqlQuerySeatNumbers);
            $resultSeatNumbers = $dbDataSeatNumbers->fetch_assoc();

            $reservedSeatNumbers[] = $resultSeatNumbers["number"];
        }

        return $reservedSeatNumbers;
    }

    public function creatingSeatReserved() {
        $reservedSeats = explode(",", $this->reserved_seats);

        for ($i = 0; $i<sizeof($reservedSeats); $i++) {
            if ($reservedSeats[$i] === "") {
                unset($reservedSeats[$i]);
            }
        }

        $reservationModel = new ReservationModel();
        $reservationModel->mapData($reservationModel->lastCreated());

        $this->reservation_id = $reservationModel->reservation_id;

        foreach ($reservedSeats as $reservedSeat) {
            $sqlString = "
                SELECT s.seat_id
                FROM seat s
                INNER JOIN auditorium a on s.auditorium_id = a.auditorium_id
                INNER JOIN screening scr on a.auditorium_id = scr.auditorium_id
                INNER JOIN reservation r on scr.screening_id = r.screening_id
                WHERE  
                    s.number = '$reservedSeat'
                    AND scr.screening_id = '$this->screening_id'
                    AND r.reservation_id = '$this->reservation_id';
            ";

            $dbData = $this->db->conn()->query($sqlString);
            $seatId = $dbData->fetch_assoc();
            $this->seat_id = $seatId["seat_id"];

            $this->create();
        }

    }

    public function table(): string
    {
        return "seat_reserved";
    }

    public function attributes(): array
    {
        return [
            "seat_id",
            "reservation_id",
            "screening_id"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}