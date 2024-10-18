<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailsManager extends Mailable
{
    use Queueable, SerializesModels;
    protected $array;

    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->array;
        return $this->view($this->array['view'], $data)
            ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
            ->subject($this->array['subject']);
    }
}
