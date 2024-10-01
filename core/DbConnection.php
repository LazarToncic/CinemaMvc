<?php

namespace app\core;

use mysqli;

class DbConnection
{
    public function conn(): mysqli
    {
        $sql = new mysqli("localhost", "root", "", "cinema_vbis");

        return $sql;
    }
}