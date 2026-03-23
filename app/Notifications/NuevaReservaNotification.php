<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NuevaReservaNotification extends Notification
{
    use Queueable;

    protected $reserva;

    public function __construct($reserva)
    {
        $this->reserva = $reserva;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'reserva_id' => $this->reserva->id,
            'titulo' => 'Nueva reserva',
            'mensaje' => 'Nueva reserva en ' . $this->reserva->cancha->nombre,
            'cliente' => $this->reserva->cliente->nombres,
            'cancha' => $this->reserva->cancha->nombre,
            'fecha' => $this->reserva->fecha,
            'hora_inicio' => $this->reserva->hora_inicio,
            'hora_fin' => $this->reserva->hora_fin,

            // CLAVE
            'url' => route('reservas.partials.show', $this->reserva->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'reserva_id' => $this->reserva->id,
            'titulo' => 'Nueva reserva',
            'mensaje' => 'Nueva reserva en ' . $this->reserva->cancha->nombre,
            'url' => route('reservas.partials.show', $this->reserva->id),
        ];
    }
}
