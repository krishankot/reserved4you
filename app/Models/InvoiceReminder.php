<?php

namespace App\Models;

use App\Mail\InvoiceEmailReminder;
use App\Models\Contract\BankDetails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;


class InvoiceReminder extends Model
{

    protected $fillable = [
        'bill_id', 'due_date', 'payment_date', 'name'
    ];

    public function bill()
    {
        return $this->belongsTo('App\Models\InvoiceBill', 'bill_id');
    }

}
