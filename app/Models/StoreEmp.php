<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreEmp extends Model
{
    protected $table = 'store_emps';

    protected $fillable = ['store_id','emp_name','country','image','status','state','zipcode','longitude','latitude','bank_name','account_holder','account_number','iban',
        'swift_code','branch','employee_id','email','phone_number','dob','joinning_date','payout','worktype','hours_per_week','address'];

    protected  $appends = ['emp_image_path'];

    public function getEmpImagePathAttribute()
    {        
        //return $this->image != null  ?  \URL::to('storage/app/public/store/employee/').'/'. $this->image : Url('storage/app/public/default/default-user.png');
		return $this->image != null  ?  \URL::to('storage/app/public/store/employee/').'/'. $this->image : NULL;

    }
    //emp time slote
    public function EmpTimeSlot()
    {
        return $this->hasMany('App\Models\StoreEmpTimeslot','store_emp_id');
    }
	
	 //emp breaks
    public function EmpBreakSlot()
    {
        return $this->hasMany('App\Models\StoreEmpBreakslot','store_emp_id');
    }

    //category
    public function EmpCategory()
    {
        return $this->hasMany('App\Models\StoreEmpCategory','store_emp_id','id')->select('id','store_emp_id','category_type','category_id');
    }

    public function EmpService()
    {
        return $this->hasMany('App\Models\StoreEmpService','store_emp_id','id')->select('id','store_emp_id','service_id');
    }

    //store data
    public function storeDetaials()
    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id')->select('id','user_id','store_name','store_start_time','store_end_time','store_district');
    }

    public function EmpDayTiming()
    {
        return $this->belongsTo('App\Models\StoreEmpTimeslot','store_emp_id');

    }

    public function employeeRated()
    {
        return $this->hasMany('App\Models\StoreRatingReview','emp_id','id');
    }
}
