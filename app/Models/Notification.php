<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table  = 'notifications';
    protected $fillable = ['title','description','type','appointment_id','store_id','user_id','other','visible_for'];
}
