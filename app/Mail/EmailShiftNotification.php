<?php

namespace App\Mail;

use App\Models\Histories;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailShiftNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $history;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Histories $history)
    {
        $this->user = $user;
        $this->history = $history;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Shift Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.email-shift-notification',
            with: [
                'user' => $this->user,
                'history' => $this->history,
            ],
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
