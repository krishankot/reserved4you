<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreProfile extends Model
{
    protected $table = 'req_store_profiles';

    protected $fillable = ['user_id','store_name','store_contact_number','store_link_id','store_description','store_address','cancellation_period','store_profile','store_banner',
	'next_stop', 'bus_or_train_line', 'google_ratings', 'accepted_terms', 'customer_data', 'employee_data', 'advantage_data', 'service_data'];
	
	
	 public function store_category()
    {
        return $this->hasMany('App\Models\Request\RequestStoreCategory', 'request_store_id','id');
    }
	
	 public function storeFeature()
    {
        return $this->hasMany('App\Models\Request\RequestStoreFeature', 'request_store_id','id');
    }

	 public function requestPaymentMethod()
    {
        return $this->hasMany('App\Models\Request\RequestPaymentMethod', 'request_store_id','id');
    }
	
	 public function advantages()
    {
        return $this->hasMany('App\Models\Request\RequestAdvantage', 'request_store_id','id');
    }
	public function transportations()
    {
        return $this->hasMany('App\Models\Request\RequestPublicTransportation', 'request_store_id','id');
    }
	
	public function requestCustomer()
    {
        return $this->hasOne('App\Models\Request\RequestCustomer', 'request_store_id','id')->select('request_store_id','customer_name', 'customer_email', 'cust_address', 'customer_country', 'postal_code', 'image as customer_image_name');
    }
	
	public function portfolios()
    {
        return $this->hasMany('App\Models\Request\RequestStorePortfolioImage', 'request_store_id','id');
    }
	
	public function requestStoreTiming()
    {
        return $this->hasMany('App\Models\Request\RequestStoreTiming', 'request_store_id','id');
    }
	
	public function employees()
    {
        return $this->hasMany('App\Models\Request\RequestStoreEmp', 'request_store_id','id')->select('*', 'image as imagename');
    }
	
	public function service()
    {
        return $this->hasMany('App\Models\Request\RequestStoreService', 'request_store_id','id')->select('*', 'image as imagename');
    }
}