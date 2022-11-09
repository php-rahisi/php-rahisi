<?php

use App\Controllers\testController;
use support\Routing\Route;

Route::Get("",function(){
   view("welcome");
});

// or

Route::Get("welcome",[testController::class,"index"]);
