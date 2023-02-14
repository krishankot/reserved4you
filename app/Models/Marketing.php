<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    protected $table = 'tbl_marketing';

    protected $fillable = ['store_id','Service_name','Service_plan','plan_type','Service_amount'];
}
