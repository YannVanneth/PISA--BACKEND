<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class VerifyOTPMail extends Mailable
{
    use Queueable, SerializesModels;


    public string $emailMessage;
    public string $otp_code;
    public string $username;
    public string $expire_at;
    public bool $isRegistered;
    public bool $found = false;

    /**
     * Create a new message instance.
     */
    public function __construct(string $emailMessage, string $otp_code = "", string $username = "", string $expire_at = "", bool $isRegistered = false, bool $found = false)
    {
        $this->emailMessage = $emailMessage;
        $this->otp_code = $otp_code;
        $this->username = $username;
        $this->expire_at = $expire_at;
        $this->isRegistered = $isRegistered;
        $this->found = $found;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'PISA - Verification Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.RegisterOtpMail_EN',
            with:
            [
                'emailMessage' => $this->emailMessage,
                'isRegistered' => $this->isRegistered,
                'found' => $this->found,
                'otp_code' => $this->otp_code,
                'username' => $this->username,
                'expire_at' => $this->expire_at,
            ]
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
