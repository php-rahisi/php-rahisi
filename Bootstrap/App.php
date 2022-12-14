<?php

use support\token\token;
use Symfony\Component\HttpFoundation\Request;

new \support\lib\dictionaly();


$request = Request::createFromGlobals();

    $token = new token(); 
    $token->setTocken();
    include "App/Helper.php";
    lastTwoUrl();
    
   
    if(!isset($_COOKIE['language'])){
        setcookie('language',$_ENV['APP_LANGUAGE']);
    }