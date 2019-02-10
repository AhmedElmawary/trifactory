<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Event extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'details',
        'address',
        'event_start',
        'event_end',
        'country',
        'city',
        'published',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'event_start' => 'date',
        'event_end'=>'date'
    ];

    protected $table='events';

    protected $primaryKey='id';

    public function scopeUpcomming($query)
    {
        return $query->where('event_start', '>=', Carbon::today());
    }

    public function scopePublished($query)
    {
        return $query->where('published', 'yes');
    }

    // public function eventsimage()
    // {
    //     return $this-> hasMany('App\Eventsimage', 'event_id');
    // }

    public function race()
    {
        return $this-> hasMany('App\Race', 'event_id');
    }
}
