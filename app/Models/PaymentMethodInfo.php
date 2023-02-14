<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodInfo extends Model
{
    protected $table = 'payment_method_infos';

    protected $fillable = [
        'user_id',
		'card_type',
        'store_id',
        'service_id',
        'order_id',
        'payment_id',
        'refund_id',
        'total_amount',
        'status','date',
        'time','appoinment_id',
        'payment_method',
        'payment_type'
    ];

    public function serviceData()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }


    public function userData()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function appointmentData(){
        return $this->belongsTo('App\Models\ServiceAppoinment', 'appoinment_id');
    }


    public function storeData()
    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id');
    }
}
