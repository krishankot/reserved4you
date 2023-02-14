<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    protected $connection = 'mysql1';

    protected $table = 'tbl_bank_details';
}
