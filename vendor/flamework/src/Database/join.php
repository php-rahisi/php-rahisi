<?php
namespace support\Database;

use DB\connection\connect;
use \PDO;
use stdClass;

class join extends connect{

    // public $con;
    public $select;
    
    public function __construct($query)
    {
        $this->select = $query;
    }

    public function get(){
        return $this->runQuery($this->select);
    }

    public function value($collum)
    {
        return $this->runQueryReturnValue($this->select,$collum);
        
    }
    

    public function rowCount()
    { 
        return $this->select->rowCount();
    }

    // public function exist($collum)
    // {
    //     return $this->runQueryReturnValue($this->select,$collum);
    // }

    public function where($condition)
    {
        $query = $this->select->queryString.= " WHERE ". $condition;
        return $this->db()->query($query);
    }

    public function runSelect($query,$bind){
    //    $db = new connect;
       $prepare = $this->db()->prepare($query);
       $exc = $prepare->execute($bind);
        return $prepare;
    }

    public function runQuery(&$obj)
    {
        $data = [];
        $x = 0;
        while($a = $obj->fetch(PDO::FETCH_ASSOC)){
            $data[$x] = $a;
            $x++;
        }
        return $data;
    }

    public function rowNumber(&$obj)
    {
        return $obj->rowCount();
    }

    public function runQueryReturnValue(&$obj,$collum)
    {
        $data = [];
        $x = 0;
        while($a = $obj->fetch(PDO::FETCH_ASSOC)){
            $data[$x] = $a[$collum];
            $x++;
        }
        return $data;
    }

}