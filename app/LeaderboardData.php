<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderboardData extends Model
{
    protected $fillable = [
        'race_id',
        'bib',
        'name',
        'email',
        'club',
        'gender',
        'gender_position',
        'category',
        'category_position',
        'country_code',
        'points'
    ];
}
