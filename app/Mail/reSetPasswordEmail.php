<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class reSetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $token;
    private $name;
    /**
     * Create a new message instance.
     */
    public function __construct($name,$token)
    {
        $this->name=$name;
        $this->token=$token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'reset your PASSWORD ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ResetPassword',with:['name'=>$this->name,'url'=>config('myConfig.resetPasswordUrl') . $this->token]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
