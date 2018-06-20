<?php

namespace FederalSt\Notifications;

use FederalSt\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateVehicleNotification extends Notification
{
    use Queueable;

    public $vehicle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
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
        return (new MailMessage)
            ->error()
            ->greeting(trans('email.greeting'))
            ->line( trans('email.editar_veiculo_motivo'))
            ->line('A Placa do Veículo é '.$this->vehicle->plate.'.')
            ->action('Verificar sua Lista', url('/'))
            ->subject(trans('email.editar_veiculo_subject'))
            ->salutation(trans('email.salutation'));
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
