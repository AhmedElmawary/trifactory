<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'amount',
        'sender_id',
        'user_id',
        'usedOn',
    ];
    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
}
