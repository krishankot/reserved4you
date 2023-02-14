<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;

class RequestPublicTransportation extends Model
{
    protected $table = 'req_public_transportations';

    protected $fillable = ['request_store_id','title','transportation_no','image','status'];

}