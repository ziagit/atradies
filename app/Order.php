<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{ 
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function addresses(){
        return $this->belongsTo(Address::class,'address_id','id');
    }
  
    public function contacts(){
        return $this->belongsTo(Contact::class,'contact_id','id');
    }
    public function options(){
        return $this->belongsToMany(Option::class);
    }


    //remove it 
    public function job()
    {
        return $this->hasOne(Job::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function jobWithStatus(){
        return $this->job()->with('jobstatus');
    }
}
