<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = ['user_id','store_id','order_id','total_amount','first_name','last_name','email','phone_number','appointment_type'];

    public function employeeDetails()    {
        return $this->belongsTo('App\Models\StoreEmp', 'store_emp_id');
    }

    public function serviceDetails()    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function storeDetails()    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id');
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

    public function orderServiceDetails()
    {
        return $this->belongsTo('App\Models\Service','service_id','id')->select('id','service_name','image','price');
    }

    public function paymentData(){
        return $this->belongsTo('App\Models\PaymentMethodInfo', 'id');
    }

    public function appointmentDetail()
    {
        return $this->hasMany(AppointmentData::class,'appointment_id','id');
    }
}
