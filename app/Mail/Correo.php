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
    public $solicitud;
    public $movimiento;
    public $tipoMail;
    public $url;
    /**
     * Create a new message instance.
     */
    public function __construct($solicitud,$tipoMail)
    {
        $this->solicitud = $solicitud;
        //$this->movimiento = $movimiento;
        $this->tipoMail = $tipoMail;
        $this->url = env('APP_URL');
    }
       /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        //SOLICITUD NUEVA O EN CURSO
        if($this->tipoMail == '1' || $this->tipoMail == '2' ){
            $subject = 'SS - Solicitud N° '.$this->solicitud->Id;
        //SOLICITUD TERMINADA
        }else if( $this->tipoMail == '3' ){
            $subject = 'SOLICITUD DE INGRESO CAMANCHACA N° '.$this->solicitud->Id;

        }else{
            $subject = 'SS - Solicitud N° '.$this->solicitud->Id;
        }

        return new Envelope(
                from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_NOMBRE')), 
                subject: $subject,                   
        );
       
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $rutArray = explode('-', $this->solicitud->RUT);
        $this->solicitud->RUT = number_format($rutArray[0],0,',','.').'-'.$rutArray[1];
        
        switch ($this->tipoMail) {
            // CASO 1 - Nueva solicitud
            case '1':
                $view= 'email.solicitud_nueva';
                break;
            // CASO 2 - Solicitud Etapa Aprobada y en Curso (Solicitud Pendiente)
            case '2':
                $view = 'email.solicitud_en_curso';
                break;
            // CASO 3 - Solicitud Terminada y APROBADA EPI
            case '3':
                foreach ($this->solicitud->Atributos as $key => $value) {
                    // Convertir las fechas a timestamps
                    $fecha1_timestamp = strtotime($value->Fecha1);
                    $fecha2_timestamp = strtotime($value->Fecha2);         
                    // Calcular la diferencia en segundos y convertirla a días
                    $diferencia_dias = round(($fecha2_timestamp - $fecha1_timestamp) / (60 * 60 * 24));
                    //SI ES ANUAL
                    if($diferencia_dias == 365){
                        $this->solicitud->Atributos[$key]->FechaImprimir = date('Y', $fecha1_timestamp); 
                    //OTRO CASO, DIARIO                           
                    }else{
                        $this->solicitud->Atributos[$key]->FechaImprimir = date('d-m-Y', $fecha1_timestamp);
                    }
                }
                $view = 'email.solicitud_terminada';
                break;

            // AGREGAR MAS CASOS Y VISTAS SEGUN NECESIDAD
            default:
                // Handle unexpected types (optional)
        }
        return new Content(
            markdown: $view,
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
