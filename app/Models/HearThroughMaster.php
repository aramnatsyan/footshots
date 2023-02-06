<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HearThroughMaster extends Model
{
    use HasFactory,SoftDeletes;

    public function subType(){    	
        return $this->hasMany('App\Models\HearThroughMaster','parent_id')->where('status','active');
    }
   
}