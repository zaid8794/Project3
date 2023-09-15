<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     */
    public $filename;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function build()
    {
        return $this->view('notification')
            ->subject('This is notification')
            ->attach($this->filename);
    }
}
