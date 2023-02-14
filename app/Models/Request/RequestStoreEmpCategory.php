<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestStoreEmpCategory extends Model
{
    protected $table = 'req_store_emp_categories';

    protected $fillable = ['store_emp_id', 'category_id'];

    protected $with = ['CategoryData'];
	public function CategoryData()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

}
