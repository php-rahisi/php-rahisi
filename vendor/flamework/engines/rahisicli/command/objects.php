<?php

namespace engines\rahisicli\command;

use DB\seeder\seeder;
use engines\rahisicli\contoller\makeController;
use support\Database\DB;
use support\Database\schema;

class objects
{

    public function __construct($commands)
    {
        if (isset($commands[2])) {
            echo "$commands[2]\n";
        }
    }

    public function make($option, $name)
    {
        $options = ["model", "controller", "migration"];
        if (in_array($option, $options)) {
            $this->$option($name);
        } else {
            echo "\n";
            echo "undefined key $option";
            echo "\n";
        }
    }

    public function model($name)
    {
        if (file_exists("./App/Models/$name.php")) {
            echo "\n";
            echo "      model exist";
            echo "\n";
        } else {
            $file = fopen("./App/Models/$name.php", "w");
            $table = '$table';
            $text = "<?php \n   namespace App\Models; \n\n    use support\Database\\table ;\n\nclass $name extends table \n{\n\n   public $table = '$name'; \n\n     public function __construct() \n    {\n\n         new table('$name');\n\n      }\n} ";
            fwrite($file, $text);
            fclose($file);
        }
    }

    public function controller($name)
    {
        $rename = $name . "Controller";
        if (file_exists("./App/Controllers/$rename.php")) {
            echo "\n";
            echo "      controller exist";
            echo "\n";
        } else {
            $file = fopen("./App/Controllers/$rename.php", "w");
            $table = '$table';
            $text = "<?php \nnamespace App\Controllers;\nclass $rename { \n\n     public function index() \n     {\n          // index \n     } \n} ";
            fwrite($file, $text);
            fclose($file);
        }
    }

    public function migration($name)
    {
        $schema = new schema();
        $schema->migration();
        $rename = $name . "-Table";

        if (file_exists("./Database/migrations/$rename.php")) {
            echo "\n";
            echo "      table exist";
            echo "\n";
        } else {

            $addM = fopen("./vendor/flamework/storage/migrations.txt", "a+");
            fputs($addM, $rename . "\n");
            fclose($addM);

            DB::table('migration')->insert(['name' => $rename]);
            $file2 = fopen("./vendor/flamework/storage/migrationExample.txt", "r");
            $file1 = fopen("./Database/migrations/$rename.php", "w");

            $x = 0;
            while ($a = fgets($file2)) {
                if ($x == 4) {
                    fputs($file1, "class $name{\n");
                } elseif ($x == 7) {
                    fputs($file1, '        $users2->create("' . $name . '", function (create $table) {' . "\n");
                } else {
                    fputs($file1, $a);
                }
                $x++;
            }
            fclose($file1);
            fclose($file2);
            echo "migration created successful";
        }
    }

    public function DB($name)
    {
        $seeder = new seeder();
        $seeder->seed();
    }
}
