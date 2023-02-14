<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class AppleUser extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_pic',
        'phone_number',
        'address',
		'state',
        'city',
        'country',
        'zipcode',
		'device_id',
        'device_token',
        'device_type',
        'user_type',
        'social_type',
        'social_id',
        'apple_id',
		'apple_user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function UserData()
    {
        return static::leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', 2);
    }

    public static function Admin()
    {
        return static::leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', 1);
    }

    protected  $appends = ['user_image_path'];

    public function getUserImagePathAttribute()
    {
        return $this->profile_pic != null  ?  \URL::to('storage/app/public/user/').'/'. $this->profile_pic : NULL;

    }

    public function userAddress()
    {
        return $this->belongsTo('App\Models\UserAddress','user_id');

    }

}
