<?php

namespace App\Nova\Filters;

use DB;
use App\UserRace;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class OrderRace extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';



    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->from("user_races")->
                        join("races", "races.id", "=", "user_races.race_id")
                        ->join('orders', 'orders.id', '=', 'user_races.order_id')
                        ->join('users', 'users.id', '=', 'user_races.user_id')
                        ->select(
                            "orders.id"
                            , "paymob_order_id"
                            , "totalCost"
                            , "success"
                            , "orders.user_id"
                            , "orders.created_at"
                            , "orders.updated_at"
                        )
                        ->where("race_id", $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $races = \App\Race::with('event')->get()->pluck('event.name', 'name')->all();
        $options = [];
        foreach ($races as $key => $value) {
            $options[$value.' - '.$key] = \App\Race::where('name', $key)->first()['id'];
        }
        return $options;
    }
}
