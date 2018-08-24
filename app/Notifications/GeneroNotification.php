<?php

namespace App\Notifications;

use App\Genero;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GeneroNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $nombre, $fecha, $asunto, $texto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Genero $genero, $fechaAct = false)
    {
        $this->nombre = $genero->nombre;
        if($fechaAct == false){
            $this->asunto = 'Género enviado a papelera';
            $this->texto = 'envió a la papelera';
            $this->fecha = $genero->deleted_at;
        } else {
            $this->asunto = 'Género restaurado';
            $this->texto = 'restauró';
            $this->fecha = $genero->updated_at;
        }
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->greeting('Saludos!')
            ->subject($this->asunto)
            ->line("Se ".$this->texto." el género " . $this->nombre . "a las " . $this->fecha);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
