<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function order(){
        return $this->hasOne(Order::class);
    }
    public function orders(){
        return $this->hasOne(Order::class);
    }
    
}
