<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userEmail;
    private $ticketMail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userEmail, Mailable $ticketMail)
    {
        $this->userEmail = $userEmail;
        $this->ticketMail = $ticketMail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->userEmail)->send($this->ticketMail);
        } catch (\Exception $e) {
            \App\Exception::create([
                'message' => $e->getMessage(),
                'data' => $this->ticketMail,
                'location' =>
                'Line:' . __LINE__
                    . ';File:' . __FILE__
                    . ';Class:' . __CLASS__
                    . ';Method:' . __METHOD__
            ]);
        }
    }
}
