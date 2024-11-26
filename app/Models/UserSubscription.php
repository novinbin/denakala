<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    //
    protected $table = 'user_subscriptions';
    protected $fillable = [
        'id','user_id','status','subscription_id'
    ];
}
