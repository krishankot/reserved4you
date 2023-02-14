<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreEmp extends Model
{
    protected $table = 'req_store_emps';

    protected $fillable = ['request_store_id','start_of_activity','emp_name','country','image','status','state','zipcode','longitude','latitude','bank_name','account_holder','account_number','iban',
        'swift_code','branch','employee_id','email','phone_number','dob','joinning_date','payout','worktype','hours_per_week','address'];

	protected $with = ['EmpTimeSlot', 'EmpCategory', 'EmpLanguages'];

    public function getEmpImagePathAttribute()
    {        
        return $this->image != null  ?  \URL::to('storage/app/public/store/employee/').'/'. $this->image : Url('storage/app/public/default/default-user.png');

    }
	
	
    //emp time slote
    public function EmpTimeSlot()
    {
        return $this->hasMany('App\Models\Request\RequestStoreEmpTimeslot','store_emp_id','id');
    }

    //category
    public function EmpCategory()
    {
        return $this->hasMany('App\Models\Request\RequestStoreEmpCategory','store_emp_id','id');
    }
	
	 public function EmpLanguages()
    {
        return $this->hasMany('App\Models\Request\RequestStoreEmpLanguages','emp_id','id');
    }


}
