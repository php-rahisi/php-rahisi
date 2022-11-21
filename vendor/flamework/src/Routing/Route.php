<?php
namespace support\Routing;

use support\Routing\Routes;
use support\token\token;

class Route
{
    static function Get($name, $action)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //************* Get the url name  ********** */
            $uri = urldecode(       //*****///*** */ */
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)  //**** */
            );
            /**********/ /****//**/ //*** */ */ */ */
            $urlArray = uri($uri);
            $url = end($urlArray);
            if ($name == $url) {
                session_url($url);
                if (is_array($action)) {
                    $function = $action[1];
                    $class = new $action[0];
                    $class->$function();
                    
                }  else {
                    $action();
                }
            }
        }
    }

    static function Post($name, $action)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['csrf_Token'])){
                $token = new token();
                if(!$token->checkToken($_POST['csrf_Token'])){
                    echo "page expiled error 500";
                    die;
                }
            }else{
                echo "page expiled error 500";
                die;
            }
            $uri = urldecode(       //*****///*** */ */
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)  //**** */
            );
            /**********/ /****//**/ //*** */ */ */ */
            $urlArray = uri($uri);
            $url = end($urlArray);
            if ($name == $url) {
                session_url($url);
                if (is_array($action)) {
                    $function = $action[1];
                    $class = new $action[0];
                    $class->$function();
                } else {
                    $action();
                }
                return new Routes();
            }
        }
    }

    // static function Get($name, $action)
    // {
    //      $get = new Routes();
    //     return $get->Get($name, $action);
    // }

    // static function Post($name, $action)
    // {
    //     $post = new Routes();
    //     return $post->Post($name, $action);
    // }
}