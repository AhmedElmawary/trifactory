<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRace extends Model
{
    protected $table = 'user_races';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 
        'race_id', 
        'tracker_id', 
        'ticket_id', 
        'created_at', 
        'updated_at',
    ];
    
    public function questionanswer()
    {
        return $this->hasMany('App\QuestionAnswer', 'userrace_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function race()
    {
        return $this->belongsTo('App\Race', 'race_id');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'ticket_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
