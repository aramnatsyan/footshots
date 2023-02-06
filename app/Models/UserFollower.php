<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFollower extends Model
{
    use HasFactory,SoftDeletes;

    public function getfollower(){

        return $this->hasOne('App\Models\User','id','follower_id');
    }
    public function getfollowing(){

        return $this->hasOne('App\Models\User','id','following_id');
    }

   
    
}
