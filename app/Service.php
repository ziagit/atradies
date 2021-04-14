<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function steps(){
        return $this->hasMany(Step::class);
    }
}
