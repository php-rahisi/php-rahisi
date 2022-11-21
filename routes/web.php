<?php

use App\Controllers\testController;
use support\Routing\Route;
use support\token\token;
use support\view\rahisi;

Route::Get("",function(){
   view("welcome");
});

// or

Route::Get("welcome",[testController::class,"index"]);

Route::Get("test", function(){
   rahisi::view("resources/views/test.rahisi.php",["names"=>["juma","rose"]]);
});

Route::Post("test", function(){
   csrf();
 });