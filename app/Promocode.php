<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $table = 'promocodes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['code', 'value', 'published', 'created_at', 'updated_at'];

    public function races()
    {
        return $this->belongsToMany('App\Race');
    }

    public function userPromocodeOrder()
    {
        return $this->belongsTo('App\UserPromocodeOrder', 'id', 'promocode_id');
    }
}
