<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Fields\Text;
use App\Imports\LeaderboardDataImport;

class LeaderboardData extends Resource
{

    use SoftDeletes;

    public static $importer = LeaderboardDataImport::class;
    // public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\LeaderboardData';
    public static $group = 'Content';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'email',
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
            Text::make('Race', 'race_id')->sortable(),
            Text::make('BIB', 'bib')->sortable(),
            Text::make('Name', 'name')->sortable(),
            Text::make('Email', 'email')->sortable(),
            Text::make('Club', 'club')->sortable(),
            Text::make('Gender', 'gender')->sortable(),
            Text::make('Gender Position', 'gender_position')->sortable(),
            Text::make('Category', 'category')->sortable(),
            Text::make('Category Position', 'category_position')->sortable(),
            Text::make('Country code', 'country_code')->sortable(),
            Text::make('Points', 'points')->sortable(),
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
        return [
            new \Sparclex\NovaImportCard\NovaImportCard(LeaderboardData::class),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
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
        return [];
    }
}
