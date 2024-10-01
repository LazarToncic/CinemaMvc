<?php

namespace app\models;

use app\core\DbModel;

class ReservationModel extends DbModel
{
    public string $reservation_id;
    public string $screening_id;
    public string $employee_reserved;
    public string $user_id;
    public string $total_price;
    public string $reservation_type_id;
    public bool $reserved;
    public string $employee_paid;
    public bool $paid;
    public bool $active;
    public string $created_at;

    //pomoc u ListReservationModel
    public string $type_name;
    public string $email;

    public function creatingReservation($email) {
        $sqlQuery = "
            SELECT u.user_id
            FROM user u
            where email = '$email'
        ";
        $dbData = $this->db->conn()->query($sqlQuery);
        $id = $dbData->fetch_assoc();

        $this->user_id = $id["user_id"];
        $this->reservation_type_id = 1;
        $this->reserved = true;
        $this->paid = false;
        $this->active = true;

        $this->create();
    }

    public function table(): string
    {
        return "reservation";
    }

    public function attributes(): array
    {
        return [
            "screening_id",
            "user_id",
            "total_price",
            "reservation_type_id",
            "reserved",
            "paid",
            "active"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}