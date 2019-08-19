<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;
use App\UserRace;

class UserRaceCount extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $user_races = UserRace::with(['race', 'race.event'])->whereHas('race.event', function($q){
            $q->where('published', 'yes')->where('event_end', '>=', date("Y-m-d"));
        })->join('races', 'races.id', '=', 'race_id');
        return $this->count($request, $user_races, 'races.name');
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-races-count';
    }
}
