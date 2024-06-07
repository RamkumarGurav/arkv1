<?php
include_once( APPPATH."third_party/shiprocket/auth.php");

// namespace payu\PayUClient;
/**
 * key & salt values are provided by your AM from PayU side
 */
 $key = __pg_key__;
 $salt = __pg_salt__;
class PayUClient extends base
{
  function __construct($key,$salt)
  {
    $this->key = $key;
    $this->salt = $salt;
//     $creds = base :: getInstance();
     $creds = new base();
    $creds->set($key,$salt);
     $Array_var = (array) $creds;

  }
}

 ?>
