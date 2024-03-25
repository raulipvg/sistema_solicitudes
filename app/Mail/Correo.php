<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class Correo extends Mailable
{
    use Queueable, SerializesModels;
    public $solicitudId;
    public $movimiento;
    public $tipoMail;
    /**
     * Create a new message instance.
     */
    public function __construct($solicitudId,$movimiento,$tipoMail)
    {
        $this->solicitudId = $solicitudId;
        $this->movimiento = $movimiento;
        $this->tipoMail = $tipoMail;
    }
       /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('juntos.pruebas.24@gmail.com', 'Sist. Solicitudes'), 
            subject: 'SS - Solicitud # '.$this->solicitudId,                   
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        switch ($this->tipoMail) {
            case '1':
                $view= 'email.nueva_solicitud';
                break;
            case '2':
                $view = 'email.aprobador';
                break;
            // Add more cases for other email types
            default:
                // Handle unexpected types (optional)
        }
        return new Content(
            view: $view,
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
