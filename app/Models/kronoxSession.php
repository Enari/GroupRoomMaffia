<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KronoxSession extends Model
{
    protected $fillable = [
        'MdhUsername', 
        'JSESSIONID',
    ];

    public function poll(){
        $url = 'https://webbschema.mdh.se/ajax/ajax_session.jsp?op=anvandarId';
        $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
              "Cookie: JSESSIONID=" . $this->JSESSIONID . ";\r\n",
              'method'  => 'GET',
          )
        );

        $context  = stream_context_create($options);
        try {
            $result = file_get_contents($url, false, $context);
            if($result == "OK"){
                $this->sessionActive = true;
            }
            else{
                $this->sessionActive = false;
            }
            $this->save();
        }
        catch (\Exception $e) {
        }
    }
}
