<?php

namespace support\Database;

use DB\connection\connect;
use DB\migrations\mytables;
use support\Database\table;
use \PDO;
use stdClass;

class schema extends connect
{
    public function create($table, $function)
    {
        $c = new create();
        $b = $function($c);

        try {
            //code...
            $this->db()->query("START TRANSACTION;");

            $sql = "CREATE TABLE `$table` ($c->collums )";
            $this->db()->query($sql);
            // die;

            $this->db()->query("COMMIT;");

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function migration()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `migration`(
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `batch` INT(1) DEFAULT 0)";
                
            $this->db()->query($sql);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function dropTable($name)
    {
        try {
            $sql = "DROP TABLE `$name`";

            $this->db()->query($sql);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function seeder(array $seeder)
    {
        
    }
}

class create
{
    public $table;
    public $collums;
    public $primary;
    public $unique;
    public $increment;

    /**
     * 
     * function to create primary key ID collum
     * if $name is array 
     * [$name, defaut 65, default not null, default value]
     * $name[0] = name of collum
     * $name[1] = lengh of collum
     * $name[2] = required status of collum
     * $name[3] = default value
     * @return $this
     */
    public function id()
    {
        $sql = "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY";
        $query = $this->appendQuery($this->collums, $sql);
        $this->collums = $query;
    }


    /**
     * @param array|string $name  
     * function to create string collum
     * if $name is array 
     * [name, defaut 65, default not null, default value]
     * $name[0] = name of collum
     * $name[1] = lengh of collum
     * $name[2] = required status of collum
     * $name[3] = default value
     * @return $this
     */
    public function varstring($name)
    {
        $p = $this->checkPallameters($name);
        $sql = "`$p[0]` VARCHAR($p[1]) $p[2]";
        $collum = $this->default($name, $sql);
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }

    /**
     * @param array|string $name  
     * function to create string collum
     * if $name is array 
     * [name, defaut 65, default not null, default value]
     * $name[0] = name of collum
     * $name[1] = lengh of collum
     * $name[2] = required status of collum
     * $name[3] = default value
     * @return $this
     */
    public function int($name = ["name", 255, "NOT NULL"])
    {
        $p = $this->checkPallameters($name);
        $sql = "`$p[0]` INT($p[1]) $p[2]";
        $collum = $this->default($name, $sql);
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }

    /**
     * @param array|string $name  
     * function to create float collum
     * if $name is array 
     * [name, defaut 65, default not null, default value]
     * $name[0] = name of collum
     * $name[1] = lengh of collum
     * $name[2] = required status of collum
     * $name[3] = default value
     * @return $this
     */
    public function float($name = ["name", 65, "NOT NULL"])
    {
        $p = $this->checkPallameters($name);
        $sql = "`$p[0]` FLOAT($p[1]) $p[2]";
        $collum = $this->default($name, $sql);
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }

    /**
     * @param array|string $name  
     * function to create decimal collum
     * if $name is array 
     * [name, defaut 65, default not null, default value]
     * $name[0] = name of collum
     * $name[1] = lengh of collum
     * $name[2] = required status of collum
     * $name[3] = default value
     * @return $this
     */
    public function decimal($name = ["name", 65, "NOT NULL"])
    {
        $p = $this->checkPallameters($name);
        $sql = "`$p[0]` DECIMAL($p[1]) $p[2]";
        $collum = $this->default($name, $sql);
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }


    public function created_at()
    {
        $collum = "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }

    /**
     * @param array|string $name  
     * function to create date collum
     * if $name is array 
     * [name, defaut 65, default not null, default value]
     * $name[0] = name of collum
     * $name[1] = lengh of collum || can be empty string
     * $name[2] = required status of collum
     * $name[3] = default value
     * @return $this
     */
    public function date($date = ["name", "", "NOT NULL", ""])
    {
        $p = $this->checkPallameters($date);
        $sql = "`$p[0]` DATE $p[2]";
        $collum = $this->default($date, $sql);
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }

    public function datetime($date = ["name", "", "NOT NULL", ""])
    {
        $p = $this->checkPallameters($date);
        $sql = "`$p[0]` TIMESTAMP $p[2]";
        $collum = $this->default($date, $sql);
        $query = $this->appendQuery($this->collums, $collum);
        $this->collums = $query;
    }

    public function increment($p = ["name", 255, "NOT NULL"])
    {
        $name = $this->checkPallameters($p);
        $sql = "ALTER TABLE `$this->table`
        MODIFY `$name[0]` int($name[1]) $name[2] AUTO_INCREMENT;";
        $this->increment = $sql;
    }

    public function unique($p = ["name", 65, "NOT NULL"])
    {
        $name = $this->checkPallameters($p);
        $sql = "ALTER TABLE `$this->table`
        ADD UNIQUE KEY `$name[0]` (`$name[0]s`);";
        $this->increment = $sql;
    }

    public function primary($p = ["name", 65, "NOT NULL"])
    {
        $name = $this->checkPallameters($p);
        $sql = "ALTER TABLE `$this->table`
        ADD PRIMARY KEY (`$name[0]`);";
        $this->increment = $sql;
    }



    public function appendQuery($query, $toadd)
    {
        if (!empty($query)) {
            $query .= ", " . $toadd;
        } else {
            $query = $toadd;
        }
        return $query;
    }

    public function checkPallameters($p)
    {
        if (is_array($p)) {

            if(isset($p1) && empty($p[1])){
                $p[1] === "60";
            }

            if(isset($p2) && empty($p[2])){
                $p[2] === "NOT NULL";
            }

        } elseif (is_string($p)) {
            $pv = [];
            $pv[0] = $p;
            $pv[1] = 65;
            $pv[2] = "not null";
            $p = $pv;
        }
        return $p;
    }

    public function default($data, $sql)
    {
        if (is_array($data) && isset($data[3])) {
            $def = $data[3];
            return $sql .= " DEFAULT $def";
        } else {
            return $sql;
        }
    }
}

class stringfy
{
    public function __contruct()
    {
    }
}
