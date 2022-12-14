<?php

namespace support\Routing;

use App\Models\User;

class Routes{
    
    public function __constructure($action)
    {
        if (is_array($action)) {
            $function = $action[1];
            $class = new $action[0];
            $class->$function();
            
        }  else {
            $action();
        }
    }
    
    public function uri($uri)
    {
        return explode("/", $uri);
    }

    static function Request()
    {
        $uri = urldecode(       //*****///*** */ */
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)  //**** */
        );
        /**********/ /****//**/ //*** */ */ */ */
        $url = end(uri($uri));
        return $request = [
            "request" => $_REQUEST,
            "http_user_agent" => $_SERVER['HTTP_USER_AGENT'],
            "language_accepted" => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
            "cookie" => $_SERVER['HTTP_COOKIE'],
            // "sever" => $_SERVER['SERVER_SIGNATURE'],
            "request_methode" => $_SERVER['REQUEST_METHOD'],
            "request_time" => $_SERVER['REQUEST_TIME'],
            "url" => $url,
        ];
    }
}