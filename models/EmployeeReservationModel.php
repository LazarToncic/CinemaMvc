<?php

namespace app\models;

use app\core\Application;
use app\core\Controller;
use app\core\DbModel;

class EmployeeReservationModel extends DbModel
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

    //user email uz pomoc kojeg nadjemo user ID
    public string $user_email;

    //pomoc za uzimanje statusa paid u changePaidStatus - ovde
    public string $paidStatus;
    public string $activeStatus;

    public function getEmployeeFullName($employeeReserved, $employeePaid) {
        $sqlEmployeeReserved = $this->db->conn()->query("
            SELECT concat(u.name, ' ', u.last_name) as full_name
            FROM user u
            WHERE
                u.email = '$employeeReserved';
        ");

        $dbDataEmployeeReserved = $sqlEmployeeReserved->fetch_assoc();
        $resultEmployeeReserved = $dbDataEmployeeReserved["full_name"] ?? false;

        $sqlEmployeePaid = $this->db->conn()->query("
            SELECT concat(u.name, ' ', u.last_name) as full_name
            FROM user u
            WHERE
                u.email = '$employeePaid';
        ");

        $dbDataEmployeePaid = $sqlEmployeePaid->fetch_assoc();
        $resultEmployeePaid = $dbDataEmployeePaid["full_name"] ?? false;

        $this->employee_reserved = $resultEmployeeReserved;
        $this->employee_paid = $resultEmployeePaid;
    }

    public function getUserId($userEmail) {
        $sqlString = $this->db->conn()->query("
            SELECT u.user_id
            FROM user u
            WHERE
                u.email = '$userEmail';
        ");

        $result = $sqlString->fetch_assoc();
        $this->user_id = $result["user_id"] ?? false;
    }

    public function changePaidStatus() {
        $status = false;

        if ($this->paidStatus === 'not_paid') {
            $status = true;
        }

        if ($this->paidStatus === 'paid') {
            $status = false;
        }

        $sqlString = "
                UPDATE reservation
                SET
                    paid = '$status'
                WHERE
                    reservation_id = '$this->reservation_id';
            ";

        $this->db->conn()->query($sqlString);

        return json_encode($status);
    }

    public function changeActiveStatus() {
        $status = false;

        if ($this->activeStatus === 'not_active') {
            $status = true;
        }

        if ($this->activeStatus === 'active') {
            $status = false;
        }

        $sqlString = "
                UPDATE reservation
                SET
                    active = '$status'
                WHERE
                    reservation_id = '$this->reservation_id';
            ";

//        var_dump($sqlString);
//        exit;

        $this->db->conn()->query($sqlString);

        return json_encode($status);
    }

    public function table(): string
    {
        return "reservation";
    }

    public function attributes(): array
    {
        return [
            "screening_id",
            "employee_reserved",
            "user_id",
            "total_price",
            "reservation_type_id",
            "reserved",
            "employee_paid",
            "paid",
            "active"
        ];
    }

    public function rules(): array
    {
        return [
            "screening_id" => [self::RULE_REQUIRED],
            "employee_reserved" => [self::RULE_REQUIRED],
            "total_price" => [self::RULE_REQUIRED],
            "employee_paid" => [self::RULE_REQUIRED],
            "paid" => [self::RULE_REQUIRED]
        ];
    }
}