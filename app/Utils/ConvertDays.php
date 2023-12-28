<?php

namespace App\Utils;

class ConvertDays
{

    public static function day($dayName)
    {
        $day = null;
        switch ($dayName) {
            case 'Monday':
                $day = 'Senin';
                break;
            case 'Tuesday':
                $day = 'Selasa';
                break;
            case 'Wednesday':
                $day = 'Rabu';
                break;
            case 'Thursday':
                $day = 'Kamis';
                break;
            case 'Friday':
                $day = 'Jum`at';
                break;
            case 'Saturday':
                $day = 'Sabtu';
                break;
            case 'Sunday':
                $day = 'Minggu';
                break;

            default:
                break;
        }
        return $day;
    }
}
