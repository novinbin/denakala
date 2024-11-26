<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementLocation extends Model
{
    //

    protected $table = 'advertisement_locations';


    protected $fillable = [
        'province_id',
        'city_id',
    ];


}
