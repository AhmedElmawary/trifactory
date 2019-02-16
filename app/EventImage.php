<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EventImage extends Model
{
    use Notifiable;

    protected $fillable = [
        'event_id','image','created_at','updated_at'
    ];
    protected $table='eventsimages';
    protected $primaryKey='id';
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
    //
}
