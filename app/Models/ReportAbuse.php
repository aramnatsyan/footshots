<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportAbuse extends Model
{
    use HasFactory,SoftDeletes;

	protected $fillable = ['target_type', 'target_id', 'user_id', 'description', 'content_id', 'status', 'created_at', 'deleted_at', 'updated_at'];
                       
      public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function getReportedProduct(){

        return $this->hasOne('App\Models\Product','id','target_id')
        ->whereTargetType('product')
        ->whereStatus('active');
    }

     public function getReportedUser(){

        return $this->hasOne('App\Models\User','id','target_id')
        ->whereTargetType('user')
        ->whereStatus('active');
    }
    public function getReportedPost(){

        return $this->hasOne('App\Models\post','id','target_id')
        ->whereTargetType('post')
        ->whereStatus('active');
    }


    
}
