<?php

namespace engines\rahisicli\command\start;

class StartCommand{
    public function __construct($command)
    {
     if(isset($command)){
        echo "\n";
        exec('php -S localhost:8000');
        echo "\n";
     }
        
    }
}