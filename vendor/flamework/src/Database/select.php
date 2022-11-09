<?php

namespace support\Database;

use DB\connection\connect;
use \PDO;
use stdClass;

class select extends connect
{

    // public $con;
    public $select;
    public $bind;

    public function __construct($query, $bind)
    {
        $this->select = $query;
        $prev_bind = $this->bind;
        if (is_array($prev_bind)) {
            $binds = array_merge($this->bind, $bind);
        } else {
            $binds = $bind;
        }

        $this->bind = array_merge($binds);
        return $this->select;
    }

    public function get()
    {
        $prepare = $this->db()->prepare($this->select);
        $exc = $prepare->execute($this->bind);
        $data = [];
        $x = 0;
        while ($a = $prepare->fetch(PDO::FETCH_ASSOC)) {
            $data[$x] = $a;
            $x++;
        }
        return $data;
    }

    public function save()
    {
        try {
            $prepare = $this->db()->prepare($this->select);
            $exc = $prepare->execute($this->bind);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function value($collum)
    {
        $prepare = $this->db()->prepare($this->select);
        $exc = $prepare->execute($this->bind);
        $data = [];
        $x = 0;
        while ($a = $prepare->fetch(PDO::FETCH_ASSOC)) {
            $data[$x] = $a[$collum];;
            $x++;
        }
        return $data;
        // return $this->runQueryReturnValue($this->select,$collum);
    }


    public function rowCount()
    {
        return $this->select->rowCount();
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
            $arg = "";
            if (
                array_search("WHERE", explode(" ", $this->select))
                && empty(explode("WHERE", $this->select)[1])
            ) {
                $arg = "";
            } elseif (
                array_search("WHERE", explode(" ", $this->select))
                && !empty(explode("WHERE", $this->select)[1])
            ) {
                $arg = "AND";
            } else {
                $arg = "WHERE";
            }

            $query = $this->select .= " $arg " . $conditions;
            $prev_bind = $this->bind;
            if (is_array($prev_bind)) {
                $binds = array_merge($this->bind, $bindCond);
            }
            return new select($query, $binds);
        } else {
            $conditions = $condition;
            $query = $this->select .= $conditions;
            return new select($query, $this->bind);
        }
    }

    public function runSelect($query, $bind)
    {
        //    $db = new connect;
        $prepare = $this->db()->prepare($query);
        $exc = $prepare->execute($bind);
        return $prepare;
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

    public function rowNumber(&$obj)
    {
        return $obj->rowCount();
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
}
