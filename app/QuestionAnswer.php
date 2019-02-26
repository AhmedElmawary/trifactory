<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $table='question_answers';
    
    protected $primaryKey='id';

    protected $fillable = [
        'userrace_id',
        'question_id',
        'answer_value',
        'created_at',
        'updated_at'
    ];

    public function userrace()
    {
        return $this->belongsTo('App\UserRace', 'userrace_id');
    }
    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }
}
