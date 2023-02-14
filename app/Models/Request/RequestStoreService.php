<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreService extends Model
{
    protected $table = 'req_store_services';

    protected $fillable = ['request_store_id','category_id','subcategory_id','service_name','price','discount','image','status','subservice','price_subservice','duration_subservice','description','duration_of_service','discount_type'];

   protected $with = ['sub_service', 'CategoryData', 'subCategoryData'];
	public function sub_service()
    {
        return $this->hasMany('App\Models\Request\RequestStoreSubservice','request_store_service_id','id');
    }
	
	public function CategoryData()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
	
	public function subCategoryData()
    {
        return $this->belongsTo('App\Models\Category', 'subcategory_id');
    }
}
