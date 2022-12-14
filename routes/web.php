<?php

use App\Controllers\testController;
use support\Routing\Route;
use support\token\token;
use support\view\rahisi;
use Symfony\Component\HttpFoundation\Request;

Route::Get("",function(){
   view("welcome");
});

// or

Route::Get("welcome",[testController::class,"index"]);

Route::Get("test", function(){
   
});

Route::Post("test", function(){
   
});