<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Voucher;
use App\Mail\SendTicketEmail;
use Mail;
use Hash;
use App\User;

class EmailTicket
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $ticketId = $event->ticketId;
        $ticket = $event->ticket;
        $user = $event->user;
        $self = false;
        $other = false;
        $newAccount = false;

        $email = 'E-mail';

        if ($user->email === $ticket->$email) {
            $self = true;
            Mail::to($user->email)->send(new SendTicketEmail($ticketId, $user, $ticket, $self, $other, null, null));
        } else {
            Mail::to($user->email)->send(new SendTicketEmail($ticketId, $user, $ticket, $self, $other, null, null));
            $fromUser = $user;
            $user = User::where('email', $ticket->$email)->first();
            if (!$user) {
                $newAccount = true;
                $name = explode(" ", $ticket->For);
                
                if (!$name[1]) {
                    $name[1] = '';
                }
                
                $nationality = null;
                $year_of_birth = 0;
                $club = '';

                foreach ($ticket as $key => $value) {
                    if (preg_match("/nationality/i", $key)) {
                        $nationalities = \countries();
                        unset($nationalities['il']);
                        $nationality = $value;
                        foreach ($nationalities as $key => $n) {
                            if ($n['name'] == $value) {
                                $nationality = $n['iso_3166_1_alpha2'];
                            }
                        }
                    }
                    if (preg_match("/year of birth/i", $key)) {
                        $year_of_birth = $value;
                    }
                    if (preg_match("/club/i", $key)) {
                        $club = $value;
                    }
                    if (preg_match("/others/i", $key)) {
                        if ($value) {
                            $club = $value;
                        }
                    }
                }

                

                $user = User::create([
                    'name' => $ticket->For,
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'email' => $ticket->$email,
                    'nationality' => $nationality,
                    'year_of_birth' => $year_of_birth,
                    'club' => $club,
                    'phone' => $ticket->Phone,
                    'password' => Hash::make(uniqid('TFP')),
                ]);
            }
            
            $other = true;
            
            Mail::to($ticket->$email)->send(new SendTicketEmail(
                $ticketId,
                $user,
                $ticket,
                $self,
                $other,
                $fromUser,
                $newAccount
            ));
        }
    }
}
