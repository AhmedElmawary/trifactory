<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answervalue extends Model
{
    protected $fillable = [
        'value','question_id','created_at','updated_at'
      ];

    protected $table='answervalues';
    protected $primaryKey='id';

    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }
    //
}
