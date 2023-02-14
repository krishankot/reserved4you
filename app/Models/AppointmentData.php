<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentData extends Model
{
    protected $table = 'appointment_data';

    protected $fillable = ['appointment_id','store_id','category_id','subcategory_id','service_id','service_name','variant_id','price',
        'status','store_emp_id','appo_date','appo_time','is_postponed','cancel_reason','refund_id','app_end_time','cancelled_by','is_notified', 'note_image'];


    public function employeeDetails()    {
        return $this->belongsTo('App\Models\StoreEmp', 'store_emp_id');
    }

    public function appointmentDetails()    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id');
    }

    public function serviceDetails()    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }


    public function variantData()    {
        return $this->belongsTo('App\Models\ServiceVariant', 'variant_id');
    }


    public function storeDetails()    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id');
    }

    public function categoryDetails()    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function subCategoryDetails()    {
        return $this->belongsTo('App\Models\Category', 'subcategory_id');
    }


    public function userDetails()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function orderInfo()
    {
        return $this->belongsTo('App\Models\PaymentMethodInfo', 'id','appoinment_id');
    }

    public function orderExpert()
    {
        return $this->belongsTo('App\Models\StoreEmp', 'store_emp_id','id');
    }
}
