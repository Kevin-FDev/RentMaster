<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalDueReminderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $rentalName;
    public $endDate;

    /**
     * Create a new message instance.
     */
    public function __construct($rentalName, $endDate)
    {
        $this->rentalName = $rentalName;
        $this->endDate = $endDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏰ RentMaster - Lembrete: Seu aluguel vence em 2 dias!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rental_due_reminder', // Aponta para o HTML de aviso
        );
    }
}
