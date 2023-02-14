<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;

class Extraservice extends Model
{
    protected $connection = 'mysql1';

    protected $table = 'tbl_extra_service';

    protected $fillable = ['store_id','Service_name','Service_plan','plan_type','Service_amount'];
}
