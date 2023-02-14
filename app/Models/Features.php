<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    protected $table = 'features';

    protected $fillable = ['name','image','status'];

    protected  $appends = ['specifics_image_path'];

    public function getSpecificsImagePathAttribute()
    {
        return $this->image != null  ?  \URL::to('storage/app/public/features/').'/'. $this->image : Url('storage/app/public/default/default-user.png');

    }
}
