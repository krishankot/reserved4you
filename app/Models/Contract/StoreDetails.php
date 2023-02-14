<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;

class StoreDetails extends Model
{
    protected $connection = 'mysql1';

    protected $table = 'tbl_store_detail';

}
