<?php

namespace App\Nova;

use App\Nova\Actions\DownloadQrCode;
use App\Nova\Actions\SendQrCodeViaEmail;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use App\Nova\Filters\Race;
use App\Nova\Actions\UserQuestionsAnswers;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use App\Nova\Actions\RemoveUserRaceDuplicates;

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
        'id',
        'participant_ticket_id',
    ];

    public static $searchRelations = [
        'User' => ['name'],
        'Order' => ['id'],
        'Ticket' => ['name'],
        'Participant' => ['name'],
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
            ID::make()->sortable(),
            HasMany::make('QuestionAnswer'),
            BelongsTo::make('User'),
            Text::make('Tracker ID', 'tracker_id'),
            BelongsTo::make('Race'),
            BelongsTo::make('Order')->nullable(),
            BelongsTo::make('Ticket'),
            BelongsTo::make('Participant', 'participant', 'App\Nova\User'),
            Text::make('Ticket ID', 'participant_ticket_id'),
            Text::make('Comments', 'comment')
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
                    $raceId = (int) $filter->value;
                }
            }
        }

        return [
            (new UserQuestionsAnswers($raceId))->askForFilename(),
            (new DownloadExcel)->withHeadings()->askForFilename(),
            new RemoveUserRaceDuplicates,
            new SendQrCodeViaEmail(),
            new DownloadQrCode()
        ];
    }
}
