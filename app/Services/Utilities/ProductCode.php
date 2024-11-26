<?php


namespace App\Services\Utilities;


use App\Models\Advertisement;

class ProductCode
{


    public static function  generateToken()
    {
        $code = uniqid('GDSH');

        if (self::existToken($code)) {

            return  $code = uniqid('GDSH');
        }
        return $code;

    }

    public static function existToken($code)
    {
        return Advertisement::where('code', $code)->exists();
    }

}
