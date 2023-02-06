<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory,SoftDeletes;

     protected $appends = [
        'product_url',
        'rating_avg',
        'total_users_rated',
    ];

       public function getTotalUsersRatedAttribute($value)
    {       
         return $this->getProductRating()->distinct('review_by')->count();
      
    }   
    public function getRatingAvgAttribute($value)
    {       
         
            $rate= floatval(number_format((float)($this->getProductRating()->avg('stars')),1,'.',''));
            if($rate == 0){
              $rate=0.0 ;
            }
            return $rate;
    }
    public function getProductUrlAttribute($value)
    {       
         $url = '/share/index.php?type=get_user_product&action_id='.$this->id; 
         return url($url);
    }
   public function getBrand(){

        return $this->hasOne('App\Models\Brand','id','brand_id');
    }
   public function getModel(){

        return $this->hasOne('App\Models\ProductModel','id','model');
    } 
    public function getPost(){

        return $this->hasOne('App\Models\Post','id','post_id');
    }
  public function getActiveBrand(){

        return $this->hasOne('App\Models\Brand','id','brand_id')->whereStatus('active');;
    }
   public function getActiveModel(){

        return $this->hasOne('App\Models\ProductModel','id','model')->whereStatus('active');;
    }
     public function getProductCategory(){

        return $this->hasOne('App\Models\ProductCategory','id','product_category');
    } 
    public function getProductDocument(){

        return $this->hasMany('App\Models\ProductDocument','product_id','id');
    }
    public function getProductCondition(){

        return $this->hasOne('App\Models\ProductCondition','id','product_condition');
    }
    public function getUser(){

        return $this->hasOne('App\Models\User','id','user_id');
    } 
    public function getProductComment(){

        return $this->hasMany('App\Models\ProductComment','product_id','id');
    }
    public function getProductLike(){

        return $this->hasMany('App\Models\ProductLike','product_id','id');
    }
    public function getProductView(){

        return $this->hasMany('App\Models\ProductView','product_id','id');
    }
    public function getProductAbuseReport(){

        return $this->hasMany('App\Models\ReportAbuse','target_id','id')
        ->whereTargetType('product')
        ->whereStatus('active');
    }
    public function getProductWishlist(){
        return $this->hasMany('App\Models\ProductWishlist','product_id','id');
     
    } 


    public function getProductRating(){
        return $this->hasMany('App\Models\ProductReview','product_id','id');
     
    }


public static function boot(){
   	parent::boot();
   	self::deleting(function($product){

	     $product->getProductComment()->each(function($getProductComment){
	      $getProductComment->delete();
	     });
    
         $product->getProductWishlist()->each(function($getProductWishlist){
	      $getProductWishlist->delete();
	     });
      $product->getProductDocument()->each(function($getProductDocument){
	      $getProductDocument->delete();
	     });
        
	});
   }

}