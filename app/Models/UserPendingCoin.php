<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPendingCoin extends Model
{
    use SoftDeletes;
    
  protected $fillable = [  'user_id', 'to_user_id', 'product_id', 'coin_qty', 'request_type', 'cleared_at', 'created_at', 'updated_at', 'deleted_at'];  
  

   public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    } 

    public function getToUser(){

        return $this->hasOne('App\Models\User','id','to_user_id');
    } 

    public function getProduct(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
