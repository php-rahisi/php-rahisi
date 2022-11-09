<?php

namespace support\Database;

use DB\connection\connect;
use \PDO;
// use support\Database\Select_collum;

class table extends connect

{

    public $table;
    public $query;

    public function __construct($table)
    {
        return $this->table = $table;
    }

    public function get()
    {
        return $this->runQuery($this->select);
    }

    public function all()
    {
        $query = new select("select * from `$this->table`", []);
        return $query;
    }

    public function find($id)
    {
        return $q = $this->where("`id` = $id");
    }

    public function join(string $joint)
    {
        $query = new select("SELECT * from $this->table JOIN $joint ", []);
        return $this->query = $query;
    }

    public function where($condition)
    {
        $conditions = "";
        $bindCond = [];
        if (is_array($condition)) {
            $x = 0;
            $commer = "";
            foreach ($condition as $key => $value) {
                if ($x > 0) {
                    $commer = ",";
                }
                $conditions .= "$commer $key = ?";
                $bindCond[$x] = $value;
                $x++;
            }
        } else {
            $conditions = $condition;
        }
        $query = new select("SELECT * from $this->table WHERE $conditions", $bindCond);
        return $query;
    }

    public function whereRaw($condition)
    {
        // $query = new select("$this->query where $condition", []);
        return $this->query . "where" . $condition;
    }

    public function selectCollum(string $collums = '*')
    {
        return new select_collum($collums, $this->table);
    }

    public function value($collum)
    {
        return $this->runQueryReturnValue($this->select, $collum);
    }

    public function insert(array $data = ["collum" => "value"])
    {
        $toInsert = "";
        $bind = [];
        $x = 0;
        $commer = "";
        $toBInd = "";
        foreach ($data as $key => $value) {
            if ($x > 0) {
                $commer = ",";
            }
            $toInsert .= "$commer `$key`";
            $toBInd .=  "$commer ?";
            $bind[$x] = $value;
            $x++;
        }

        $sql = "INSERT INTO $this->table ($toInsert) VALUES ($toBInd)";
        $this->execute($sql, $bind);
        $id = $this->lastId($this->table);
        return $this->where("`id` = $id");
    }

    public function update(array $data = ["collum" => "value"])
    {
        $toupdate = "";
        $bind = [];
        $x = 0;
        $commer = "";
        foreach ($data as $key => $value) {
            if ($x > 0) {
                $commer = ",";
            }
            $toupdate .= "$commer `$key` = ?";
            $bind[$x] = $value;
            $x++;
        }

        $sql = "UPDATE $this->table SET $toupdate WHERE";
        $query = new select($sql, $bind);
        return $query;
    }

    public function delete(array $conditionData = ["collum" => "value"])
    {
        $toDelete = "";
        $bind = [];
        $x = 0;
        $commer = "";
        foreach ($conditionData as $key => $value) {
            if ($x > 0) {
                $commer = " AND ";
            }
            $toDelete .= "$commer `$key` = ?";
            $bind[$x] = $value;
            $x++;
        }
        $sql = "DELETE FROM $this->table WHERE $toDelete";
        return $this->execute($sql, $bind);
    }

    public function execute($query, $bind)
    {
        //    $db = new connect;
        $prepare = $this->db()->prepare($query);
        $exc = $prepare->execute($bind);
        return $exc;
    }

    public function runQuery(&$obj)
    {
        $data = [];
        $x = 0;
        while ($a = $obj->fetch(PDO::FETCH_ASSOC)) {
            $data[$x] = $a;
            $x++;
        }
        return $data;
    }

    public function runQueryReturnValue(&$obj, $collum)
    {
        $data = [];
        $x = 0;
        while ($a = $obj->fetch(PDO::FETCH_ASSOC)) {
            $data[$x] = $a[$collum];
            $x++;
        }
        return $data;
    }

    public function lastId($table)
    {
        $sql = "SELECT `id` FROM `$table` WHERE id = (SELECT MAX(id) FROM `$table`) ";
        $stmt = $this->db()->query($sql);
        $data = $stmt->fetch();
        return  $data['id'];
    }
}
