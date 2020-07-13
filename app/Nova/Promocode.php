<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Actions\RemovePromocodeDuplicates;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\Select;
use OptimistDigital\MultiselectField\Multiselect;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Promocode extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */

    public static $model = 'App\Promocode';
    public static $group = 'Operations';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
        'value'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Code', 'code')->sortable(),
            Text::make('Value', 'value')->sortable(),
            Boolean::make('Published', 'published')
                ->trueValue('yes')
                ->falseValue('no'),
            Number::make('Limit', 'limit')->sortable(),
            Boolean::make('Unlimited', 'unlimited')
                ->trueValue(1)
                ->falseValue(0),
            // BelongsToMany::make('Races', 'races'),
            BelongsTo::make('Event', 'events'),
            Multiselect::make('Races', 'promo_races')
            ->options(
                $this->racesOptions()
            )
            ->reorderable(true)
            ->placeholder("Promocode's Avialabe Races"),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new DownloadExcel)->withHeadings()->askForFilename(),
            // new RemovePromocodeDuplicates
        ];
    }
    
    private function racesOptions()
    {
        $event = $this->events()->first();
        if ($event == null) {
            return;
        }
        $races = $event->race()->get();
        $returned = [];
        foreach ($races as $race) {
            $returned[$race->id] = $race->name;
        }
        return $returned;
    }
}
