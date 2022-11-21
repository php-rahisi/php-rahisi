<?php

use support\token\token;
new \support\lib\dictionaly();

    include "Env.php";

    $token = new token(); 
    $token->setTocken();
    include "App/Helper.php";
    lastTwoUrl();
    
   
    if(!isset($_COOKIE['language'])){
        setcookie('language',$_ENV['APP_LANGUAGE']);
    }