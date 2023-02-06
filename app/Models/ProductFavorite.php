<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFavorite extends Model
{
    use HasFactory,SoftDeletes;

     protected $table = 'product_favorites';

    public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function getProduct(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }
    
}