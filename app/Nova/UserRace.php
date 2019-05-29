<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use App\Nova\Filters\Race;
use App\Nova\Actions\UserQuestionsAnswers;

class UserRace extends Resource
{
    public static $group = "Operations";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\UserRace';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'User',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            HasMany::make('QuestionAnswer'),
            BelongsTo::make('User'),
            Text::make('Tracker ID', 'tracker_id'),
            BelongsTo::make('Race'),
            BelongsTo::make('Order')->nullable(),
            BelongsTo::make('Ticket'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new Race];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        $raceId = 0;
        $filters = json_decode(base64_decode($request->filters));
        if ($filters) {
            foreach ($filters as $filter) {
                if ($filter->class === 'App\\Nova\\Filters\\Race') {
                    $raceId = $filter->value;
                }
            }
        }
        return [
            (new UserQuestionsAnswers($raceId))->askForFilename()
        ];
    }
}
