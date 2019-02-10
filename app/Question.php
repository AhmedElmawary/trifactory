<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_text','answertype_id','created_at','updated_at'
      ];

    protected $table='questions';
    protected $primaryKey='id';
      //
    public function answertype()
    {
        return $this-> belongsTo('App\AnswerType');
    }
    public function answervalue()
    {
        return $this-> hasMany('App\Answervalue');
    }
    public function race()
    {
        return $this->belongsToMany('App\Race', 'race_question');
    }
    //
}
