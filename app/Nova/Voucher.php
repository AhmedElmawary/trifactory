<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Currency;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Voucher extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Voucher';
    public static $group = 'Operations';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'reciver_email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
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
            // ID::make()->sortable(),
            Text::make('Code', 'code')->sortable(),
            Currency::make('Amount', 'amount'),
            BelongsTo::make('User', 'user'),
            BelongsTo::make('Sender', 'sender', 'App\Nova\User'),
            Date::make('Used On', 'usedOn')->sortable(),
            BelongsTo::make('Order'),

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
        return [
            (new DownloadExcel)->withHeadings()->askForFilename(),
        ];
    }
}
