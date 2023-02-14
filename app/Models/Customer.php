<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['store_id','user_id','name','email','phone_number','address','state','zipcode','image'];
	
	protected  $appends = ['customer_image_path'];

    public function getCustomerImagePathAttribute()
    {        
        return $this->image != null  ?  \URL::to('storage/app/public/store/customer/').'/'. $this->image : NULL;

    }
}
