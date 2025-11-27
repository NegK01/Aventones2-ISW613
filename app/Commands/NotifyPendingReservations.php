<?php

namespace App\Commands;

use App\Libraries\MailService;
use App\Models\ReservationModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class NotifyPendingReservations extends BaseCommand
{
    protected $group       = 'reservations';
    protected $name        = 'reservations:notify-drivers';
    protected $description = 'Envia notificaciones por correo a choferes con reservas pendientes.';
    protected $usage       = 'reservations:notify-drivers <minutes>';

    public function run(array $params)
    {
        $minutes = (int) ($params[0] ?? 0);

        if ($minutes <= 0) {
            CLI::error('Debe indicar los minutos como entero positivo.');
            CLI::write('Uso: ' . $this->usage, 'yellow');
            return;
        }

        $reservationModel = new ReservationModel();
        $mailService      = new MailService();

        //recoge id de reserva, id de chofer y correo del chofer 
        $reservas = $reservationModel->obtenerPendientesSinConfirmar($minutes);

        if (!$reservas) {
            CLI::write('No hay reservas pendientes que superen el limite de tiempo indicado.');
            return;
        }

        $enviados    = 0;
        $notificados = []; 

        foreach ($reservas as $reserva) {
            $correo = $reserva['correo'] ?? null;

            if (!$correo || isset($notificados[$correo])) {
                continue; // termina el ciclo y va a la siguiente reserva
            }

            if ($mailService->sendNotificationMail($correo)) {
                $enviados++; // aumentamos el numero de emails enviados
                $notificados[$correo] = true; // todos los correos de los choferes a los que se le notifico, usarlo en caso de tener que revisar si alguno no funciono
            }
        }

        CLI::write("Se han enviado {$enviados} correos de notificación.");
    }
}
