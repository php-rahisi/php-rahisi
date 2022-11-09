<?php

namespace engines\rahisicli\contoller;


class makeController{

    public function modelMaker($name)
    {
        $file = fopen("$name.php","w");

        $table = '$table';
        $text = "<?php \n
        namespace App\Models; \n

        use support\Database\table; \n
     
        class users extends table \n
        {
            
            public $table = '$name';
        
            public function __construct()
            {
                new table('$name');
            }
        }        
        ";
        fwrite($file,$text);
        fclose($file);
    }
}