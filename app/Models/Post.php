<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory,SoftDeletes;

    public function getAllActivePostProducts(){

     return $this->hasMany('App\Models\Product','post_id','id')->whereStatus('active');
    
    
      
    }
    public function getUnsoldActivePostProducts(){

        return $this->hasMany('App\Models\Product','post_id','id')->whereIsSold('N')->whereStatus('active');
      
    }
    
     public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    } 
    public function getPostComment(){

        return $this->hasMany('App\Models\PostComment','post_id','id');
    }
    public function getPostLike(){

        return $this->hasMany('App\Models\PostLike','post_id','id');
    }
    public function getPostView(){

        return $this->hasMany('App\Models\PostView','post_id','id');
    }
    public function getPostAbuseReport(){

        return $this->hasMany('App\Models\ReportAbuse','target_id','id')
        ->whereTargetType('product')
        ->whereStatus('active');
    }
    public function getPostWishlist(){
        return $this->hasMany('App\Models\ProductWishlist','product_id ','id');
     
    }

    public function getPostRating(){
       return $this->id;
        return $this->hasMany('App\Models\ProductWishlist','product_id ','id');
     
    }

  public static function boot(){
   	parent::boot();
   	self::deleting(function($post){

	     $post->getAllActivePostProducts()->each(function($product){
	      $product->delete();
	     });
    
         $post->getPostComment()->each(function($getPostComment){
	      $getPostComment->delete();
	     });
         $post->getPostLike()->each(function($getPostLike){
	      $getPostLike->delete();
	     });
         
         $post->getPostView()->each(function($getPostView){
	      $getPostView->delete();
	     });
    
        $post->getPostWishlist()->each(function($getPostWishlist){
	      $getPostWishlist->delete();
	     }); 

	   
   	});
   }

}
