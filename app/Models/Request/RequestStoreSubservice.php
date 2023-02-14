<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreSubservice extends Model
{
    protected $table = 'req_store_subservices';

    protected $fillable = ['request_store_id','request_store_service_id','subservice','price_subservice','duration_subservice'];

   
}
