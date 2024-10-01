<?php

namespace app\core;

use app\models\CategoryModel;

abstract class DbModel extends Model
{
    public DbConnection $db;

    public function __construct() {
        $this->db = new DbConnection();
    }

    abstract public function table(): string;
    abstract public function attributes(): array;

    public function create() {
        $table = $this->table();
        $attributes = $this->attributes();
        $values = array_map(fn($attr) => ":$attr", $attributes);
        $sqlString = "INSERT INTO $table(". implode(',', $attributes) .") VALUES (". implode(',', $values) .")";

        foreach ($attributes as $attribute) {
            $sqlString = str_replace(":$attribute", is_numeric($this->{$attribute}) ? $this->{$attribute} : '"'. $this->{$attribute} .'"', $sqlString);
        }

        $this->db->conn()->query($sqlString);
    }

    public function one($where) {
        $table = $this->table();
        $sqlString = "SELECT * FROM $table WHERE $where limit 1;";

        $dbResult = $this->db->conn()->query($sqlString);

        return $dbResult->fetch_assoc();
    }
    public function all(): array
    {
        $table = $this->table();
        $sqlString = "SELECT * FROM $table;";
        $dbResult = $this->db->conn()->query($sqlString);

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        return $resultArray;
    }

    public function lastCreated() {
        $table = $this->table();

        $modelId = "";

        if ($table === "reservation") {
            $modelId = "reservation_id";
        }

        if ($table === "movie") {
            $modelId = "movie_id";
        }

        if ($modelId === 'reservation_id') {
            $sqlString = "SELECT reservation_id FROM $table order by $modelId desc limit 1;";
        } else {
            $sqlString = "SELECT * FROM $table order by $modelId desc limit 1;";
        }

        //var_dump($sqlString);

        $dbResult = $this->db->conn()->query($sqlString);

        return $dbResult->fetch_assoc();
    }

    public function delete($where): bool
    {
        $table = $this->table();
        $sqlString = "DELETE FROM $table where $where;";

        $dbResult = $this->db->conn()->query($sqlString);

        return true;
    }

}