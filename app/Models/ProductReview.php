<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory,SoftDeletes;

    public function getUser(){

        return $this->hasOne('App\Models\User','id','review_by');
    }

    public function getProduct(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }
    
}

