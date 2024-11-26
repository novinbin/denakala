<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertSubscription extends Model
{
    //
    protected $table = 'advert_subscriptions';

    protected $fillable = [
        'product_id','user_subscriptions_id'
    ];
}
