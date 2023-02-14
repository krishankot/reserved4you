<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreRatingReview extends Model
{
    protected $table = 'store_rating_reviews';

    protected $fillable = ['user_id','store_id','service_rate','ambiente','preie_leistungs_rate','wartezeit','atmosphare','write_comment','total_avg_rating','category_id',
        'subcategory_id','service_id','emp_id','store_replay','appointment_id'];

    public function userDetails()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function serviceDetails()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function categoryDetails()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function subCategoryDetails()
    {
        return $this->belongsTo('App\Models\Category', 'subcategory_id');
    }

    public function empDetails()
    {
        return $this->belongsTo('App\Models\StoreEmp', 'emp_id');
    }

    public function storeDetaials()
    {
        return $this->belongsTo('App\Models\StoreProfile', 'store_id');
    }
}
