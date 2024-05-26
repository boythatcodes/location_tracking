<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InqueryEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject, $body)
    {
        $this->subject_thing = $subject;
        $this->name = $name;
        $this->email = $email;
        $this->body_thing = $body;
    }


    public function build()
    {
        return $this->subject(`Inquery from: {{ $this->name }}`)->view('emails.test')
        ->with([
            'subject'=> $this->subject_thing,
            'body' => $this->body_thing,
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

}
