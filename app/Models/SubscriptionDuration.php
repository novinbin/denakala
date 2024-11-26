<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionDuration extends Model
{
    //
    protected $table = 'subscription_durations';
    protected $fillable = [
        'subscription_id','price','duration','discount'
    ];
}
