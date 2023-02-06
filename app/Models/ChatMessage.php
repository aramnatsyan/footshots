<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ChatMessage extends Model
{
    use HasFactory,SoftDeletes;

	protected $fillable = ['text_message','chat_id','from_id', 'to_id', 'read_at', 'created_at', 'deleted_at', 'updated_at'];
                       
     

    public function getFrom(){

        return $this->hasOne('App\Models\User','id','form_id');
       
    }
   public function getTo(){

        return $this->hasOne('App\Models\User','id','to_id');
       
    }

     public function getUpdatedAtAttribute($value)
    { 
        $value=strtotime($value);

        return Carbon::parse($value)->diffForHumans();
    }



    
}
