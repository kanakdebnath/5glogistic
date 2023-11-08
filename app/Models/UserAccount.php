<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    public function payout()
    {
        return $this->hasMany(PayoutLog::class,'user_account_id');
    }

    // public function bank()
    // {
    //     return $this->hasOne(Bank::class,'id');
    // }
    
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
