<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'role', 'email_verified_at', 'remember_token', 'password', 'phone', 'phone_verified_at', 'date_of_birth', 'device_type', 'device_token', 'login_token', 'gender', 'pic', 'language', 'status', 'otp'
    ];

     protected $appends = [
    //     'follower_count',
    //     'following_count',
         'user_invite_url'
     ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
        'remember_token',
        'deleted_at',
        
        'login_token',
        'otp',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    

  public function getUserInviteUrlAttribute($value)
    {
     $url = '/invite/index.php?type=get_user_invitaion&action_id='.$this->id; 
         return url($url);
    }

   public function getEvents(){

        return $this->hasMany('App\Models\Events','user_id');
    } 

 

}
