<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCommentLike extends Model
{
    use HasFactory,SoftDeletes;

    public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function getComment(){

        return $this->hasOne('App\Models\PostComment','id','comment_id');
    }
    
}
