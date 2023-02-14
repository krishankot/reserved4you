<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceBillDetails extends Model
{
    protected $fillable = [
        'bill_id',
        'item_name',
        'price',
        'is_percentage',
    ];

    public function bills()
    {
        return $this->belongsTo('App\Models\InvoiceBill', 'bill_id');
    }
}
