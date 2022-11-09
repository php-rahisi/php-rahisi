<?php

namespace engines\rahisicli\command;

use DB\seeder\seeder;
use stdClass;
use support\Database\DB as DatabaseDB;

class DB
{
    public function __construct($commands)
    {
        if (isset($commands[2])) {
            switch ($commands[2]) {
                case 'seed':
                    $this->seed();
                    break;

                case 'schema':
                    $this->schema();
                    break;

                default:
                    echo "\n \033[31m \n command '$commands[2]' not found \033[0m \n\n";
                    break;
            }
        } else {
            echo "\n";
            echo "command \n\033[32mDB \033[0m <option>\n";
            echo "\n";
            echo "      Options";
            echo "\n";
            echo "     \033[32m seed \033[0m \n";
            echo "\n";
            echo "     \033[32m scheema \033[0m \n";
            echo "\n";
        }
    }


    public function seed()
    {
        $seeder = new seeder();
        $seeder->seed();
        echo "\n\033[32mDatabase seeded\033[0m \n";
    }

    public function schema()
    {
        $handle = fopen("php://stdin", "r");
        $resurt = "";
        $DB = new DatabaseDB();
        // $DB->where("1")->get();
        $std = new stdClass();
        $std->db = $DB;


        do {

            if (isset($std->status) && $std->status == 1) {
                echo "Schema - active>>";
            } else {
                echo "Schema>>";
            }
            $line = fgets($handle);
            $command = str_replace("\n", "", $line);
            $d = explode("->", $command);
            $d = explode("->", $command);
            $code = "";
            $fn = "";
            for ($i = 0; $i < count($d); $i++) {
                $code = $std->db;
                $c = explode("(", $d[$i]);
                $fn = $c[0];
                if (isset($c[1])) {
                    if ($fn === "print") {

                        if (is_array($std->db)) {
                            foreach ($std->db as $key => $value) {
                                print_r($value);
                            }
                        } else {
                            print_r($std->db . "\n");
                        }
                        break;
                    }

                    if ($fn === "exit") {
                        $std->db = $DB;
                        $std->status = 0;
                        break;
                    }

                    $input = explode(")", $c[1])[0];
                    $std->db = $code->$fn($input);
                    $std->status = 1;
                }
            }
        } while ($line !== 'exit');
    }
}
