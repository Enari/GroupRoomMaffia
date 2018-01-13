<?php

namespace App\Helpers;

class HelperFunctions
{
    public static function bookingIntervallToTime(int $intervall)
    {
        if ($intervall == 0) {
            return '08:15 - 10:00';
        } elseif ($intervall == 1) {
            return '10:15 - 12:00';
        } elseif ($intervall == 2) {
            return '12:15 - 14:00';
        } elseif ($intervall == 3) {
            return '14:15 - 16:00';
        } elseif ($intervall == 4) {
            return '16:15 - 18:00';
        } elseif ($intervall == 5) {
            return '18:15 - 20:00';
        } else {
            return 'incorrect intervall';
        }
    }

    public static function roomIsValid($room)
    {
        $validRooms = [
      'R1-013',
      'R1-014',
      'R1-016',
      'R1-017',
      'R1-018',
      'R1-028',
      'R1-029',
      'R1-030',
      'R2-031',
      'R2-032',
      'R2-042',
      'R2-089',
      'R2-090',
      'R2-091',
      'R2-092',
      'U2-009',
      'U2-010',
      'U2-011',
      'U2-012',
      'U2-043',
      'U2-044',
      'U2-260',
      'U2-261',
      'U2-263',
      'U2-264',
      'U2-265',
      'U2-267',
      'U2-269',
      'U2-271',
      'U2-273',
    ];

        return in_array(strtoupper($room), $validRooms);
    }

    public static function rooms()
    {
        return [
      'R1-013',
      'R1-014',
      'R1-016',
      'R1-017',
      'R1-018',
      'R1-028',
      'R1-029',
      'R1-030',
      'R2-031',
      'R2-032',
      'R2-042',
      'R2-089',
      'R2-090',
      'R2-091',
      'R2-092',
      'U2-009',
      'U2-010',
      'U2-011',
      'U2-012',
      'U2-043',
      'U2-044',
      'U2-260',
      'U2-261',
      'U2-263',
      'U2-264',
      'U2-265',
      'U2-267',
      'U2-269',
      'U2-271',
      'U2-273',
    ];
    }
}
