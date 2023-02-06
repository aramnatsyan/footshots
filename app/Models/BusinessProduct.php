<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BusinessProduct extends Model
{
    use SoftDeletes; 

   protected $fillable = [
        'brand',
        'model',
        'description',
        'link',
        'user_id',
    ];

     public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    }


}