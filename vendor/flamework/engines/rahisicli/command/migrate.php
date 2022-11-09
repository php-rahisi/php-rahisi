<?php

namespace engines\rahisicli\command;

use DB\connection\connect;
use support\Database\DB;
use support\Database\schema;

class migrate extends connect
{
    public function __construct($input)
    {
        if (!empty($input[2])) {
            switch ($input[2]) {
                case 'fresh':
                    $this->fresh();
                    break;

                default:
                    echo "\n \033[31m \n command '$input[2]' not found \033[0m \n\n";
                    break;
            }
        }else{
            $this->migrate();
        }
    }

    public function migrate()
    {

        $schema = new schema();
        $schema->migration();

        $file2 = fopen("./vendor/flamework/storage/migrations.txt", "r");

        $x = 0;
        $alltables = [];
        while ($a = fgets($file2)) {
            $name = str_replace("\n", "", $a);
            $tables = DB::table("migration")->where(["name" => $name])->get();
            // var_dump($tables);
            if (count($tables) < 1) {
                DB::table('migration')->insert(['name' => $name]);
            }
            $x++;
        }
        fclose($file2);

        $tables = DB::table("migration")->where(["batch" => 0])->get();
        if (count($tables) < 1) {
            echo "\n\n nothing to migrate!\n\n";
        }
        foreach ($tables as $tableget) {
            $table = $tableget['name'];
            $id = $tableget['id'];
            $filename = $table;
            $path = "./Database/migrations/$filename.php";
            if (file_exists($path)) {
                include($path);
                $name = explode("-", $table)[0];
                $fn = new $name();
                $fn->up();

                DB::table("migration")
                ->update(["batch" => "1"])
                ->where(['id' => $id])
                ->save();

                echo "\n\033[32m$table ------------------------------- created successful\033[0m\n\n";
            } else {
                DB::table("migration")->delete(['id' => $id]);
            }
        }
    }

    public function fresh()
    {
        $tables = DB::table("migration")->where(["batch" => 1])->get();
        foreach ($tables as $tableget) {
            $table = $tableget['name'];
            $id = $tableget['id'];
            $name = explode("-", $table)[0];
            $schema = new schema();
            $schema->dropTable($name);
        }
        foreach ($tables as $tableget) {
            $table = $tableget['name'];
            $id = $tableget['id'];
            if (file_exists("./Database/migrations/$table.php")) {
                include("./Database/migrations/$table.php");
                $name = explode("-", $table)[0];
                $fn = new $name();
                $fn->up();
                DB::table("migration")->update(["batch" => "1"])->where(['id' => $id])->save();
                echo "\n\033[32m$table ------------------------------- created successful\033[0m\n\n";
            } else {
                DB::table("migration")->delete(['id' => $id]);
            }
        }
    }
}