<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['uuid', 'payment_date', 'expires_at', 'status', 'user_id', 'clp_usd'];

    protected $hidden = ['id', 'created_at', 'updated_at'];
}
