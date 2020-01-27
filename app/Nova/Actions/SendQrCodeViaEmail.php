<?php

namespace App\Nova\Actions;

use App\Event;
use App\Events\RaceTicketQrCode;
use App\User;
use App\Race;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQrCodeViaEmail extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $participantTicketId = $model->participant_ticket_id;
            $user = User::find($model->participant_user_id);
            $race = Race::find($model->race_id);
            $event = Event::find($race->event_id);

            event(new RaceTicketQrCode($participantTicketId, $user, $race, $event));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
