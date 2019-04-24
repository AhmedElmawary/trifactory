<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVoucher extends Mailable
{
    use Queueable, SerializesModels;

    public $meta;
    public $user;
    public $voucher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($meta, $user, $voucher)
    {
        $this->meta = $meta;
        $this->user = $user;
        $this->voucher = $voucher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('The TriFactory - Voucher information')
            ->view('emails.send-voucher', [
                'meta' =>  $this->meta,
                'user' =>  $this->user,
                'voucher' =>  $this->voucher
            ]);
    }
}
