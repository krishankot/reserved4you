<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreCategory extends Model
{
    protected $table = 'req_store_categories';

    protected $fillable = ['request_store_id','category_id','category_name'];

    
	
}
