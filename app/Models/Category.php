<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['main_category', 'name', 'image', 'status','category_type','slug'];

    public function CategoryData()
    {
        return $this->belongsTo('App\Models\Category', 'main_category');
    }
    public function servicecategory()
    {
        return $this->hasMany('App\Models\Service', 'category_id','id');
    }

    public function serviceSubcategory()
    {
        return $this->hasMany('App\Models\Service', 'subcategory_id','id');
    }

    public function appoData()    {
        return $this->hasMany('App\Models\AppointmentData', 'category_id','id');
    }

    protected  $appends = ['category_image_path'];

    public function getCategoryImagePathAttribute()
    {    
        return $this->image != null  ?  \URL::to('storage/app/public/category/').'/'. $this->image : Url('storage/default/logo-03.png'); 
        
    }
}
