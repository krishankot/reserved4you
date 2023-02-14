<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreFeatures extends Model
{
    protected $table = 'store_features';

    protected $fillable = ['store_id','feature_id'];

    public function featureData()
    {
        return $this->belongsTo('App\Models\Features', 'feature_id');
    }
}
