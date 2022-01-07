<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        // $this->title = $title;
        // $this->email = $email;
        // $this->name = $name;
        // $this->expire = $expire;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // if ($this->title == 'newOrder') {
        //     $this->markdown('mail.newOrder')
        //     ->with([
        //         'email'=> $this->email,
        //         'name'=> $this->name,
        //         'name'=> $this->expire,
        //     ]);
        // }
        return $this->subject($this->details['subject'])->markdown('mail.newOrder')->with($this->details);
    }
}
