<?php
namespace engines\rahisicli\command;

class help
{
    public function __construct()
    {
        
    }

    public function pause()
    {
        $handle = fopen("php://stdin", "r");
        do {
            $line = fgets($handle);
        } while ($line == '');
        fclose($handle);
        return $line;
    }
}
