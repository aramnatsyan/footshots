<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ProductComment extends Model
{
    use HasFactory,SoftDeletes;
 protected $appends = ['commented_at'];

    public function getUser(){

        return $this->hasOne('App\Models\User','id','comment_by');
    }

    public function getProduct(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }

 public function getUpdatedAtAttribute($value)
    {  $value = '12/08/2020';
        return Carbon::createFromFormat('m/d/Y', $value)->diffForHumans();
    }
 public function getCommentedAtAttribute($value)
    {  
        return $value+1000;
    }





    
    
}

