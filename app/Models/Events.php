<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Events extends Model
{
    use SoftDeletes; 

    protected $table = 'events';

     public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    } 

     public function getSports(){

        return $this->hasOne('App\Models\Sports','id','sports');
    } 
    
    public function getLifestyle(){

        return $this->hasOne('App\Models\Lifestyle','id','lifestyle');
    } 
    
   
}
