<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class EmailResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->token = Str::random(60);
        
        DB::table('password_reset_tokens')->insert([
            'email' => $this->user->email,
            'token' => $this->token,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Reset Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.email-reset-password',
            with: [
                'email' => $this->user->email,
                'token' => $this->token,
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
