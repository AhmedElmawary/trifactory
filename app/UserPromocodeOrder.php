<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPromocodeOrder extends Model
{
    protected $table = 'user_promocode_order';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['user_id', 'order_id', 'promocode_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function promocode()
    {
        return $this->belongsTo('App\Promocode', 'promocode_id');
    }
}
