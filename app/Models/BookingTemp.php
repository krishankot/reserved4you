<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingTemp extends Model
{
    protected $table = 'booking_temps';

    protected $fillable = ['store_id','category_id','subcategory_id','service_id','service_name','variant_id','price','store_emp_id','appo_date','appo_time','app_end_time','status','timestemps'];

}
