<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwinTransaction extends Model
{
 use SoftDeletes;
 
protected $fillable =  ['user_id','clickref3', 'product_id', 'affiliateid', 'bannerid', 'clickthroughtime', 'clicktime', 'commission', 'commissiongroups', 'groupid', 'merchantid', 'phrase', 'products', 'searchengine', 'transactionamount', 'transactiondate', 'transactionid', 'url', 'transactioncurrency', 'trackedcurrency', 'trackedamount'];  

   public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    } 

    public function getProduct(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
