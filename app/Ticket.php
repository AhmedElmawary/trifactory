<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name', 'price', 'quantity','ticket_end', 'published','created_at', 'updated_at'];
    protected $casts = [
        'ticket_end'=>'date'
    ];
    
    public function race()
    {
        return $this->belongsTo('App\Race');
    }
    // public function races()
    // {
    //     return $this->belongsToMany('App\Race', 'user_races')->withTimestamps();
    // }
    // public function user()
    // {
    //     return $this->belongsToMany('App\User', 'user_races')->withTimestamps();
    // }
    // public function event()
    // {
    //     return $this->belongsToMany('App\Event', 'user_races')->withTimestamps();
    // }
}
