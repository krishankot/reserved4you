<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table = 'tbl_hardware';

    protected $fillable = ['store_id','Service_name','Service_plan','plan_type','Service_amount'];
}
