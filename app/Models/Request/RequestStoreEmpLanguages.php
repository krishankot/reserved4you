<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreEmpLanguages extends Model
{
    protected $table = 'req_store_emp_languages';

    protected $fillable = ['request_store_id','emp_id','languages'];
}
