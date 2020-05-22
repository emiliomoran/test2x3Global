<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['email'];

    protected $hidden = ['created_at', 'updated_at'];
}
