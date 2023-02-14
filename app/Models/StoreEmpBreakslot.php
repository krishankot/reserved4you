<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreEmpBreakslot extends Model
{
    protected $table = 'store_emp_breakslots';

    protected $fillable = ['store_id','store_emp_id','day','start_time','end_time','everyday'];
}
