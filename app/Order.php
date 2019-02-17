<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $primaryKey = 'id';
    
    public $timestamps = true;

    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'paymob_order_id',
        'totalCost',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
