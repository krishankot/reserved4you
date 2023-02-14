<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempServiceStore extends Model
{
    protected $table = 'temp_service_stores';

    protected $fillable = ['user_id','service','category','subcategory','variant','price','store_id','date','time','guest_email','employee'];
}
