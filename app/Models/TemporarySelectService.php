<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporarySelectService extends Model
{
    protected $table = 'temp_user_select_service';

    protected $fillable = [
            'category_id',
            'service_id',
            'service_variant_id',
            'device_token','store_id',
            'subcategory_id',
            'emp_id',
            'user_id',
            'appo_date',
            'appo_time',
            'appo_date_temp',
            'totalTime'
        ];

    public function serviceVeriant()
    {
        return $this->belongsTo('App\Models\ServiceVariant', 'service_variant_id','id');
    }

    public function serviceEmp()
    {
        return $this->belongsTo('App\Models\StoreEmp', 'emp_id','id');
    }

    public function StoreDetails()
    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id','id');
    }
}
