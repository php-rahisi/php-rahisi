<?php

namespace engines\rahisicli;

use App\Models\users;
use DB\seeder\seeder;
use engines\rahisicli\command\DB as CommandDB;
use engines\rahisicli\command\help;
use engines\rahisicli\command\make;
use engines\rahisicli\command\start\StartCommand as serve;
use stdClass;
use support\Database\DB;
use support\Database\schema;
use support\Database\table;
use engines\rahisicli\command\migrate;
// use engines\rahisicli\command\objects;

class App
{
    public $command;

    // public function runCommand(array $command)
    // {
    //     $availlable = [
    //         "start" => "run to start sever",
    //         "end" => "run to end sever",
    //         "migrate" => "run to migrate database"
    //     ];

    //     $commandsToEcxecute = [
    //         "start",
    //         "end",
    //         "migrate",
    //         "migrate:fresh",
    //         "DB:seed",
    //         "objects",
    //         "schema",
    //     ];


    //     if (count($command) > 1) {
    //         if (in_array($command[1], $commandsToEcxecute)) {
    //             if ($command[1] === "objects") {
    //                 if (isset($command[2])) {
    //                     $fn = explode(":", $command[2]);

    //                     $fn1 = $fn[0];
    //                     $fn2 = $fn[1];

    //                     $objects = new objects();
    //                     $objects->$fn1($fn2, $command[3]);
    //                 } else {
    //                     $availlable = [
    //                         "make:<option>" => "[model,controller]  run to make new object",
    //                         "help" => "run to get help",
    //                     ];
    //                     $topr = "";
    //                     foreach ($availlable as $commands => $value) {
    //                         $topr .= $commands . " => $value" . "\n";
    //                     }

    //                     echo "\n";
    //                     echo "command not found\n";
    //                     echo "\n";
    //                     echo "available commands\n";
    //                     echo "\n";

    //                     echo $topr;
    //                 }
    //             } elseif ($command[1] === "migrate" || explode(":", $command[1])[0] === "migrate") {
    //                 $objects = new migrate($command[1]);

    //                 $fn = explode(":", $command[1]);
    //                 if (is_array($fn) && count($fn) > 1) {
    //                     $opt = $fn[1];
    //                     $objects->$opt();
    //                 }
    //                 // $objects->$fn1($fn2,$command[3]);
    //             } elseif ($command[1] === "schema") {
    //                 $this->pause($command[2]);
    //             } elseif ($command[1] === "DB" || explode(":", $command[1])[0] === "DB") {
    //                 $seeder = new seeder();
    //                 $seeder->seed();
    //             }
    //         } else {
    //             echo "\n";
    //             echo "command '$command[1]' not found\n";
    //         }
    //     } else {
    //         $topr = "";
    //         foreach ($availlable as $commands => $value) {
    //             $topr .= $commands . " => $value" . "\n";
    //         }

    //         echo "\n";
    //         echo "command not found\n";
    //         echo "\n";
    //         echo "available commands\n";
    //         echo "\n";

    //         echo $topr;
    //     }
    // }

    public function runCommand(array $command)
    {
        $commandsToEcxecute = [
            "migrate",
            "migrate:fresh",
            "DB",
            "make",
            "schema",
            "serve",
        ];

        if (count($command) > 1) {
            if (in_array($command[1], $commandsToEcxecute)) {
                switch ($command[1]) {

                    case 'make:':
                        new make($command);
                        break;

                    case 'migrate';
                        new migrate($command);
                        break;

                    case 'DB';
                        new CommandDB($command);
                        break;  
                    case 'serve';
                        new serve($command);
                        break;                        
                    default:
                        new help();
                        break;
                }
            }else
                echo "\n \033[31m \n command '$command[1]' not found \033[0m \n\n";
        }
    }

    public function pause($input)
    {
        $handle = fopen("php://stdin", "r");
        $resurt = "";
        $DB = new DB();
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
