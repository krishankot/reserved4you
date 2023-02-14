<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceBill extends Model
{
    protected $fillable = [
        'invoice_id',
        'title',
        'invoice_number',
        'recurring',
        'start_date',
        'due_date',
        'sub_total',
        'total',
        'vat',
        'final_amount',
        'bill_type',
        'discount',
        'reminder_number',
        'payment_at',
        'booking_ids',
        'status',
    ];

    protected $casts = [
        'booking_ids' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\InvoiceBillDetails', 'bill_id', 'id');
    }
    
    public function reminders()
    {
        return $this->hasOne('App\Models\InvoiceReminder', 'bill_id', 'id');
    }
}
