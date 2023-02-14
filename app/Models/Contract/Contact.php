<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $connection = 'mysql1';

    protected $table = 'tbl_store_detail';
}
