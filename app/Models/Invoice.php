<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'contract_id',
        'status',
    ];

    public function bills()
    {
        return $this->hasMany('App\Models\InvoiceBill', 'invoice_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract\StoreDetails', 'contract_id');
    }
}
