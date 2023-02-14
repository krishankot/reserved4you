<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStorePortfolioImage extends Model
{
    protected $table = 'req_store_portfolio_images';

    protected $fillable = ['request_store_id','image_name'];

   
}
