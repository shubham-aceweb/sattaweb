<?php
namespace App\Classes;
use DB;

class ApiCrypterController
{
    private $iv  = 'QuLNgbtpzL67Uk7T'; #Same as in JAVA
    private $key = 'Zu87VAntTYnKTz53'; #Same as in JAVA
    
    public function __construct() {

    }
    public function auth_key($authkeydycryted) {

        $originalauthkey='6yTH2dPcY9q5YlT';
        //dycrypted key is sMZ9x11socjTPZ1ipouETA==
        $dycrytedauthkey=openssl_decrypt($authkeydycryted, 'aes-256-cbc', $this->key, 0, $this->iv);
        if($originalauthkey==$dycrytedauthkey)
        {
            return true;
        }else
        {
            return false;
        }

     
    }

    public function openssl_encrypt($data) {
      
      $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $this->iv);
      return $encrypted;
    }
    function openssl_decrypt($encrypteddate) {
      return openssl_decrypt($encrypteddate, 'aes-256-cbc', $this->key, 0, $this->iv);
    }


}

