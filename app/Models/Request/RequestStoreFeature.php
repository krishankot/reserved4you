<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreFeature extends Model
{
    protected $table = 'req_store_features';

    protected $fillable = ['request_store_id','feature_id'];
}
