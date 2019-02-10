<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Race extends Model
{
    use Notifiable;

    protected $table='races';

    protected $primaryKey='id';

    protected $fillable = [
        'event_id','name','published','details','created_at','updated_at'
    ];
    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }
    
    public function ticket()
    {
        return $this->hasMany('App\Ticket');
    }
    
    public function question()
    {
        return $this->belongsToMany('App\Question', 'race_question');
    }
    // public function userrace()
    // {
    //     return $this->hasMany('App\UserRace', 'race_id');
    // }
    //
}
