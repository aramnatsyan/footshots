<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PostComment extends Model
{
    use HasFactory,SoftDeletes;

    public function getUser(){

        return $this->hasOne('App\Models\User','id','comment_by');
    }

    public function getPost(){

        return $this->hasOne('App\Models\Post','id','post_id');
    }
public function getCommentLike(){

        return $this->hasMany('App\Models\PostCommentLike','comment_id','id');
    }


 public function getUpdatedAtAttribute($value)
    {  
        $data = new Carbon($value);
        return $data->createFromFormat('Y-m-d H:i:s', $data)->diffForHumans();
    }


    
}

