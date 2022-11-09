<?php

namespace support\Database;

use DB\connection\connect;
use \PDO;

class Where extends connect

{

    public $sql;
    public $bind;
    public $condition;

    public function __construct($sql, $condition, $bind)
    {
        $this->$condition = $condition;
        $this->sql = $sql;
        $this->bind = $bind;
    }

    public function where(array $condition)
    {
        $bind = $this->bind;
        $sql = $this->sql;
        $x = 0;
        $commer = "";
        $conditions = "";
        $bindCond = [];
        foreach ($condition as $key => $value) {
            if ($x > 0) {
                $commer = ",";
            }
            $conditions .= "$commer `$key` = ?";
            $bindCond[$x] = $value;
            $x++;
        }
        $q = $sql .= $conditions;
        return $this->execute($q,array_merge($bind,$bindCond)); 
    }

    public function execute($query, $bind)
    {
        //    $db = new connect;
        $prepare = $this->db()->prepare($query);
        $exc = $prepare->execute($bind);
        return $exc;
    }
}
