<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usercredit extends Model
{
    protected $table = 'usercredits';

    protected $fillable = [
        'user_id', 'amount', 'action', 'created_at','updated_at'
    ];
    
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
}
