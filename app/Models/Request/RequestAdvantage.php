<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestAdvantage extends Model
{
    protected $table = 'req_store_advantages';

    protected $fillable = ['request_store_id','title','description','image','status'];

}