<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $table = 'promocodes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['race_id', 'code', 'value', 'published', 'created_at', 'updated_at'];

    public function race()
    {
        return $this->belongsTo('App\Race');
    }
}
