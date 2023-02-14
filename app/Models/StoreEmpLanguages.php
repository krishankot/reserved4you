<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreEmpLanguages extends Model
{
    protected $table = 'store_emp_languages';

    protected $fillable = ['store_id','emp_id','languages'];
}
