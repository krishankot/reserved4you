<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    protected $connection = 'mysql1';

    protected $table = 'tbl_marketing';

    protected $fillable = ['store_id','Service_name','Service_plan','plan_type','Service_amount'];
}
