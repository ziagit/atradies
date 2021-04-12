<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{ 
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function addresses(){
        return $this->belongsTo(Address::class);
    }
  
    public function contacts(){
        return $this->belongsTo(Contact::class);
    }
    public function options(){
        return $this->belongsToMany(Option::class);
    }


    //remove it 
    public function job()
    {
        return $this->hasOne(Job::class);
    }
    public function jobWithStatus(){
        return $this->job()->with('jobstatus');
    }
}
