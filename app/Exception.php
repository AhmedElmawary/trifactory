<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    protected $fillable = ['message', 'data', 'location'];
    protected $table = 'exceptions';
    protected $primaryKey='id';
}
