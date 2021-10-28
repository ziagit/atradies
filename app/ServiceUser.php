<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceUser extends Model
{
    protected $table = 'service_user';

    protected $fillable = [
        'service_id',
        'user_id',
    ];
}
