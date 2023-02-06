<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessTransaction extends Model
{
 use SoftDeletes;
 
protected $fillable =  ['user_id','seller_id', 'product_id', 'buyer_id', 'commission', 'products', 'transactionamount', 'transactiondate', 'transactionid', 'url', 'transactioncurrency', 'trackedcurrency', 'trackedamount'];  

   public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    } 
public function getSeller(){

        return $this->hasOne('App\Models\User','id','seller_id');
    } 
public function getBuyer(){

        return $this->hasOne('App\Models\User','id','buyer_id');
    } 

    public function getProduct(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
