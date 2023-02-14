<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BecomePartner extends Model
{
    protected $table = 'become_partners';

    protected $fillable = ['first_name','last_name','email','phone_number','store_name','location','latitude','longitude','postal_code', 'app_date', 'app_time', 'howtomeet'];
}
