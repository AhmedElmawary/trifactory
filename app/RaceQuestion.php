<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaceQuestion extends Model
{
    protected $table='race_question';

    protected $primaryKey='id';

    public function race() {
        return $this->belongsTo('App\Race', 'race_id');
    }

    public function question() {
        return $this->belongsTo('App\Question', 'question_id');
    }
}
