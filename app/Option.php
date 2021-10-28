<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function orders(){
        return $this->belongsToMany(Order::class);
    }
    public function step(){
        return $this->belongsTo(Step::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
