<?php

namespace App\Models;

use App\Helpers\KronoxCommunicator;
use Illuminate\Database\Eloquent\Model;

class KronoxSession extends Model
{
    protected $fillable = ['MdhUsername', 'JSESSIONID', 'sessionActive', 'user'];

    public function poll()
    {
        $url = 'https://webbschema.mdh.se/ajax/ajax_session.jsp?op=poll';
        $result = KronoxCommunicator::httpGet($url, $this->JSESSIONID);
        if ($result == 'OK') {
            $this->sessionActive = true;
        } else {
            $this->sessionActive = false;
        }
        $this->save();
    }

    public function getNumberOfBookings()
    {
        return count(KronoxCommunicator::getMyBookings($this->JSESSIONID));
    }
}
