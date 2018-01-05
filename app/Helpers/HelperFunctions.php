<?php

namespace App\Helpers;

use Carbon\Carbon;

use App\Models\Booking;
use App\Models\KronoxSession;

class HelperFunctions
{
  public static function bookingIntervallToTime(int $intervall)
  {
    if ($intervall == 0){
      return "08:15 - 10:00";
    } elseif ($intervall == 1) {
      return "10:15 - 12:00";
    } elseif ($intervall == 2) {
      return "12:15 - 14:00";
    } elseif ($intervall == 3) {
      return "14:15 - 16:00";
    } elseif ($intervall == 4) {
      return "16:15 - 18:00";
    } elseif ($intervall == 5) {
      return "18:15 - 20:00";
    } else {
      return "incorrect intervall";
    }
  }
}
