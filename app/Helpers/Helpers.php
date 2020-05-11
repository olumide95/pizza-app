<?php

namespace App\Helpers;

use Carbon\Carbon;
use getID3;

class Helpers
{
    /**
     * generate order ID
     * @param $array
     * @return array
     */
    public static function OrderID($length = 6)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $id = mt_rand(100, 999)
            . mt_rand(100, 999)
            . $characters[rand(0, strlen($characters) - 1)];
        return str_shuffle($id);
    }

}
