<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'usedOn',
    ];
    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
