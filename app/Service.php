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

     /** 
    * The user that belong to the services.
    */
   public function user()
   {
       return $this->belongsToMany(User::class)->withPivot('id','created_at','updated_at');
   }
}
