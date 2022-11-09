<?php
namespace DB\connection;
use \PDO;
use \PDOException;
class connect {
    protected function db(){
        try {
            $conn = new PDO("mysql:host=".$_ENV['SEVER_NAME'].";dbname=".$_ENV['DB_NAME'],$_ENV['DB_USER_NAME'],$_ENV['PASSWORD']);
            return $conn;
        } catch(PDOException $e) {
            echo "failed: ".$e->getMessage();
        }
    }
}