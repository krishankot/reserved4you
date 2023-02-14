<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVariant extends Model
{
    protected $table = 'service_variants';

    protected $fillable = ['store_id','service_id','description','duration_of_service','price'];
}
