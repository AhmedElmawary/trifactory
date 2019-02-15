<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerType extends Model
{
    protected $fillable = [
      'name','type', 'validation', 'created_at','updated_at'
    ];

    protected $table='answertype';
    protected $primaryKey='id';

    public function question()
    {
        return $this->hasMany('App\Question', 'answertype_id');
    }
}
