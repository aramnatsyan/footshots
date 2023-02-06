<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{  
    use HasFactory,SoftDeletes;

     protected $hidden = [
        
        'deleted_at',
    
    ];

     public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id')->where('status','active');
    }
}
