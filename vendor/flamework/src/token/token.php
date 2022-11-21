<?php  
namespace support\token;

class token 
{
    public function createToken()
    {
        $str = str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890");
        $smallstr = substr($str,0,30);
        $token = base64_encode($smallstr);
        return $token;
    }

    public function setTocken()
    {
        $newToken = $this->createToken();
            if(isset($_COOKIE['csrf_Token'])){
                return $_COOKIE['csrf_Token'];
            }else{
                setcookie("csrf_Token",$newToken,time()+60*2);
                return $newToken;
            }
    }

    public function checkToken($token)
    {
        if(isset($_COOKIE['csrf_Token'])){
            if($_COOKIE['csrf_Token'] === $token){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function token()
    {
        return $this->setTocken();
    }
}