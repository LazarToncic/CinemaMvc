<?php

namespace app\models;

use app\core\DbModel;

class ListReservationModel extends DbModel
{
    public array $reservations;
    public string $search;
    public string $resType;
    public $pageIndex;
    public $rowNumbers;

    public function searchReservations() {
        if ($this->resType === "") {
            $sqlString = $this->db->conn()->query("
            SELECT r.reservation_id, u.email, rt.type_name, r.paid ,r.active, r.created_at
            FROM reservation r
            INNER JOIN user u on r.user_id = u.user_id
            INNER JOIN reservation_type rt on r.reservation_type_id = rt.reservation_type_id
            WHERE
                u.email like '%$this->search%';
        ");
        } else {
            $sqlString = $this->db->conn()->query("
            SELECT r.reservation_id, u.email, rt.type_name, r.paid ,r.active, r.created_at
            FROM reservation r
            INNER JOIN user u on r.user_id = u.user_id
            INNER JOIN reservation_type rt on r.reservation_type_id = rt.reservation_type_id
            WHERE
                u.email like '%$this->search%'
                AND r.active = '$this->resType';
        ");
        }

        $resultArray = [];

        while ($result = $sqlString->fetch_assoc()) {
            $reservationModel = new ReservationModel();
            $reservationModel->mapData($result);
            $resultArray[] = $reservationModel;
        }

        $this->reservations = $resultArray;

        return json_encode($this);
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