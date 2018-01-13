<?php

namespace App\Models;

use App\Helpers\KronoxCommunicator;
use Illuminate\Database\Eloquent\Model;

class SchedulledBooking extends Model
{
    public function book()
    {
        $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=boka';
        $url = $url.'&datum='.urlencode(substr($this->date, 2, 8));
        $url = $url.'&id='.urlencode($this->room);
        $url = $url.'&typ=RESURSER_LOKALER';
        $url = $url.'&intervall='.urlencode($this->time);
        $url = $url.'&moment='.(empty($this->message) ? '%20' : urlencode($this->message));
        $url = $url.'&flik=FLIK_0001';

        $this->result = KronoxCommunicator::httpGet($url, KronoxSession::where(['sessionActive' => 1, 'MdhUsername' => $this->booker])->first()->JSESSIONID);
        $this->save();
    }
}
