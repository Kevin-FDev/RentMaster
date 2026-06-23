<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalConfirmedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $rentalName;
    public $rentalValue;
    public $rentalDuration;

    /**
     * Create a new message instance.
     */
    public function __construct($rentalName, $rentalValue, $rentalDuration)
    {
        $this->rentalName = $rentalName;
        $this->rentalValue = $rentalValue;
        $this->rentalDuration = $rentalDuration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'RentMaster - Confirmação de Aluguel de Equipamento',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rental_confirmed', // Vamos criar essa view no próximo passo
        );
    }
}
