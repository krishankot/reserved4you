<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestPaymentMethod extends Model
{
    protected $table = 'req_payment_methods';

    protected $fillable = ['request_store_id','payment_method'];
}
