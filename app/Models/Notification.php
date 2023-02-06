<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use stdClass;

class Notification extends Model
{
    use HasFactory,SoftDeletes;

 protected $appends = [
        'notification_text',
    ];
     
      public function getFromUser(){

        return $this->hasOne('App\Models\User','id','from_user_id');
    }
    public function getToUser(){

        return $this->hasOne('App\Models\User','id','to_user_id');
    }
 public function getUpdatedAtAttribute($value)
    { 
 
        $value=$this->created_at;
       // $value=strtotime($value);
        
        return Carbon::parse($value)->diffForHumans();
    }

  public function getNotificationTextAttribute($value)
    {
     $user=$this->getFromUser()->first();
     $name=$user->firstname.' '.$user->lastname;
     return $name.' '.notification_text($this->target_type);
         
    }
}
