<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreTiming extends Model
{
    protected $table = 'req_store_timings';

    protected $fillable = ['request_store_id','day','start_time','end_time','is_off'];
}
