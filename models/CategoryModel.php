<?php

namespace app\models;

use app\core\DbModel;

class CategoryModel extends DbModel
{
    public $category_id;
    public $name;
    public $active;

    public function allCategoryModel(): array
    {
        $table = $this->table();
        $sqlString = "SELECT * FROM $table;";
        $dbResult = $this->db->conn()->query($sqlString);

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $categoryModel = new CategoryModel();
            $categoryModel->mapData($result);
            $resultArray[] = $categoryModel;
        }

        return $resultArray;
    }

    public function table(): string
    {
        return "category";
    }

    public function attributes(): array
    {
        return [
            "name",
            "active"
        ];
    }

    public function rules(): array
    {
        return [];
    }
}