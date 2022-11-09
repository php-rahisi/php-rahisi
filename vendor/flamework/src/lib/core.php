<?php

namespace support\lib;


class core
{
    public function __construct()
    {
        lastTwoUrl();
        // language();
        // var_dump($_SESSION['hitUrl']);
        if (!urlHit()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                view('error.error', ['500', 'post nethode was required on Route/wep.php eg Route::post()']);
            }
            echo("'error.error', ['404', 'PAGE NOT FOUND']");
            
        }else{
            unset($_SESSION['hitUrl']);
        }

        
    }
}
