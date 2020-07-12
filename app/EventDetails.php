<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetails extends Model
{
    protected $fillable
        = [
        'title',
        'details',
        'event_id',
        'order'
    ];

    protected $table = 'event_details';

    protected $primaryKey = 'id';

    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }
}
