<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Chat extends Model
{
    use HasFactory,SoftDeletes;

	protected $fillable = ['text_message', 'user1', 'user2','created_at', 'deleted_at', 'updated_at'];
                       
     

    public function getFrom(){

        return $this->hasOne('App\Models\User','id','form_id');
       
    }
   public function getTo(){

        return $this->hasOne('App\Models\User','id','to_id');
       
    }

    //  public function getUpdatedAtAttribute($value)
    // { 
    //     $value=strtotime($value);

    //     return Carbon::parse($value)->diffForHumans();
    // }



    
}
