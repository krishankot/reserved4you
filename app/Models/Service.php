<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StoreProfile;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Service extends Model
{
	//use SoftDeletes;
    protected $fillable = [
        'store_id',
        'category_id',
        'subcategory_id',
        'service_name',
        'start_time',
        'end_time',
        'price',
        'discount',
        'start_date',
        'end_date',
        'image','status',
        'description',
        'duration_of_service',
        'discount_type',
        'is_popular'
    ];

    protected $table = 'services';

    public function CategoryData()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function SubCategoryData()
    {
        return $this->belongsTo('App\Models\Category', 'subcategory_id');
    }

    protected  $appends = ['service_image_path'];

	 public function getDiscountAttribute()
    {    
		$is_discount  = StoreProfile::where('id', $this->store_id)->value('is_discount');
		if($is_discount == 'yes'){
			return $this->attributes['discount'];
		}else{
			return 0;
		}
    }
    public function getServiceImagePathAttribute()
    {    
        return $this->image != null  ?  \URL::to('storage/app/public/service/').'/'. $this->image : Url('storage/default/logo-03.png'); 
        
    }

    public function storeDetaials()
    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id');
    }

    public function serviceVariant()
    {
        return $this->hasMany('App\Models\ServiceVariant', 'service_id','id');
    }

    public function serviceRated()
    {
        return $this->hasMany('App\Models\StoreRatingReview','service_id','id');
    }
}
