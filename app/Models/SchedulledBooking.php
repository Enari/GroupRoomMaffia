<?php

namespace App\Models;

use Carbon\Carbon;
use App\Helpers\KronoxCommunicator;
use Illuminate\Database\Eloquent\Model;

class SchedulledBooking extends Model
{
    public function book()
    {
        $session = KronoxSession::where(['sessionActive' => 1, 'MdhUsername' => $this->booker])->first();

        if (empty($session)) {
            $this->result = 'No active session';
        } else {
            $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=boka';
            $url = $url.'&datum='.urlencode(substr($this->date, 2, 8));
            $url = $url.'&id='.urlencode($this->room);
            $url = $url.'&typ=RESURSER_LOKALER';
            $url = $url.'&intervall='.urlencode($this->time);
            $url = $url.'&moment='.(empty($this->message) ? '%20' : urlencode($this->message));
            $url = $url.'&flik=FLIK_0001';

            $this->result = KronoxCommunicator::httpGet($url, $session->JSESSIONID);
        }

        $this->save();

        // Create new booking if recurring
        if ($this->recurring == 1) {
            $new = $this->replicate();
            $new->date = Carbon::parse($new->date)->addWeek()->toDateString();
            $new->result = null;
            $new->save();
        }
    }
}
