<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'phone',
        'nationality',
        'password',
        'year_of_birth',
        'club',
        "gender",
        "fb_id",
        "profile_image",
        "api_token"
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

    public function credit()
    {
        return $this->hasMany('App\Usercredit');
    }

    public function usercredit()
    {
        return $this->hasMany('App\Usercredit');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function userrace()
    {
        return $this->hasMany('App\UserRace');
    }

    public function participantuserrace()
    {
        return $this->hasMany('App\UserRace', 'participant_user_id');
    }

    public function ticket()
    {
        return $this->hasMany('App\Ticket');
    }

    public function voucher()
    {
        return $this->hasMany('App\Voucher');
    }

    public function pastEvents()
    {
        return $this->hasMany('App\LeaderboardData', 'email', 'email');
    }

    // Generate token for API Authentication
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
}
