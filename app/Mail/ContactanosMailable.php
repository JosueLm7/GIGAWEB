<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Definimos la variable pública

    public function __construct($data)
    {
        $this->data = $data; // Asignamos los datos recibidos
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('marana@continental.edu.pe', 'Maglioni Arana Caparachin'),
            subject: 'Contactanos Mailable',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contactanos',
            // Pasamos los datos a la vista
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
