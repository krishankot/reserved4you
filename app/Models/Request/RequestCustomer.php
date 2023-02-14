<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestCustomer extends Model
{
    protected $table = 'req_customers';

    protected $fillable = ['request_store_id','customer_name','customer_email','customer_phone','cust_address','customer_country','postal_code','image','customer_data'];
}
