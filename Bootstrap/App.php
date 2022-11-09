<?php

use Symfony\Component\Dotenv\Dotenv;

    include "Env.php";
    include "App/Helper.php";
    lastTwoUrl();
    
    new \support\lib\dictionaly();
   
    if(!isset($_COOKIE['language'])){
        setcookie('language',$_ENV['APP_LANGUAGE']);
    }