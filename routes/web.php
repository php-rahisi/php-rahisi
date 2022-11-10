<?php

use App\Controllers\WelcomeController;
use support\Routing\Route;

Route::Get("",[WelcomeController::class,"index"]);

// Route::Get("",function(){
//    view("welcome");
// });

// or