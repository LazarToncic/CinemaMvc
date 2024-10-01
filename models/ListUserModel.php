<?php

namespace app\models;

use app\core\DbModel;

class ListUserModel extends DbModel
{
    public array $users;
    public string $search;
    public $pageIndex;
    public $rowNumbers;

    public function searchUsers() {
        $dbResult = $this->db->conn()->query("
            SELECT
                u.user_id,
	            u.email,
	            CONCAT(u.`name`, ' ', u.last_name) AS `name`,
	            u.created_at,
	            GROUP_CONCAT(DISTINCT(r.`name`) SEPARATOR ', ') AS user_roles
            FROM `user` u
            INNER JOIN user_role ur on u.user_id = ur.user_id
            INNER JOIN `role` r ON ur.role_id = r.role_id
            WHERE	
	            u.email LIKE '%$this->search%'
            GROUP BY
	            u.user_id
        ");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $userModel = new UserModel();
            $userModel->mapData($result);
            $resultArray[] = $userModel;
        }

        $this->users = $resultArray;

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