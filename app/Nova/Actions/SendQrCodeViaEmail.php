<?php

namespace App\Nova\Actions;

use App\Event;
use App\Events\RaceTicketQrCode;
use App\Listeners\EmailTicket;
use App\Mail\SendTicketEmail;
use App\Order;
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
            $participantUserId = $model->participant_user_id;
            $registeredUserId = $model->user_id;
            $orderId = $model->order_id;
            $order = Order::find($orderId);
            $meta = $order->meta;
            $userTicket = null;
            $fromUser = null;
            $metaParsed = json_decode($meta);
            foreach ($metaParsed as $ticketId => $ticket) {
                if ($ticketId !== 'credit' && $ticketId !== 'voucher' &&  $ticketId == $participantTicketId) {
                    $userTicket = $ticket;
                    break;
                }
            }
            $self = false;
            $other = false;
            if ($participantUserId === $registeredUserId) {
                $self = true;
            } else {
                $other = true;
                $fromUser = User::find($registeredUserId);
            }
            $participantUser = User::find($model->participant_user_id);
            event(
                new RaceTicketQrCode(
                    $participantTicketId,
                    $participantUser,
                    $userTicket,
                    $self,
                    $other,
                    $fromUser,
                    false
                )
            );
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
