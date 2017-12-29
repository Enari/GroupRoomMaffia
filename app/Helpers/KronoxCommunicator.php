<?php

namespace App\Helpers;


class KronoxCommunicator
{
    public static function httpGet($url, $JSESSIONID){
        $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
              "Cookie: JSESSIONID=" . $JSESSIONID . ";\r\n",
              'method'  => 'GET',
          ));
        $context  = stream_context_create($options);

        try {
            $result = file_get_contents($url, false, $context);
            return $result;
        }
        catch (\Exception $e) {
            return null;
        }
    }
}
