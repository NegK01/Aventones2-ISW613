<?php

namespace App\Models;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;
use RuntimeException;

class ReservationModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_ride',
        'id_chofer',
        'id_cliente',
        'fecha',
        'id_estado',
    ];

    protected $useTimestamps = false;

    public function crearReserva(array $data): int
    {
        $this->insert($data, true);
        return (int) $this->getInsertID();
    }

    public function actualizarEstado(int $reservationId, int $state): bool
    {
        return $this->update($reservationId, ['id_estado' => $state]);
    }

    public function obtenerReservasPorUsuario(int $roleId, int $userId): array
    {
        $builder = $this->select(
            "reservas.*, DATE_FORMAT(reservas.fecha, '%Y-%m-%d %H:%i') AS fechaReserva, " .
                "rides.nombre AS nombreRide, rides.origen, rides.destino, vehiculos.marca, vehiculos.modelo, vehiculos.anio"
        )
            ->join('rides', 'rides.id_ride = reservas.id_ride')
            ->join('vehiculos', 'vehiculos.id_vehiculo = rides.id_vehiculo')
            ->where('rides.id_estado', '4');

        switch ($roleId) {
            case 2: // Chofer
                $builder->join('usuarios AS cliente', 'cliente.id_usuario = reservas.id_cliente')
                    ->select('cliente.nombre AS nombreUsuario, cliente.apellido AS apellidoUsuario')
                    ->where('reservas.id_chofer', $userId);
                break;
            case 3: // Pasajero
                $builder->join('usuarios AS chofer', 'chofer.id_usuario = reservas.id_chofer')
                    ->select('chofer.nombre AS nombreUsuario, chofer.apellido AS apellidoUsuario')
                    ->where('reservas.id_cliente', $userId);
                break;
            default:
                $builder->join('usuarios AS chofer', 'chofer.id_usuario = reservas.id_chofer', 'left')
                    ->join('usuarios AS cliente', 'cliente.id_usuario = reservas.id_cliente', 'left')
                    ->select(
                        'chofer.nombre AS nombreChofer, chofer.apellido AS apellidoChofer, ' .
                            'cliente.nombre AS nombreCliente, cliente.apellido AS apellidoCliente'
                    );
                break;
        }

        return $builder->findAll();
    }

    public function obtenerReservaFiltrada($idRide, $idCliente, $idChofer): ?array
    {
        return $this->where([
            'id_ride'   => $idRide,
            'id_cliente'=> $idCliente,
            'id_chofer' => $idChofer,
            'id_estado' => 2,
        ])
        ->first() ?: null;
    }
    
    public function obtenerPendientesSinConfirmar(int $minutes): array
    {
        // retornar vacio si es menor o igual a 0
        if ($minutes <= 0) {
            return [];
        }

        //recoger id de reserva, id de chofer, correo del chofer 
        return $this->select('reservas.id_reserva, reservas.id_chofer, usuarios.correo')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_chofer')
            ->where('reservas.id_estado', 2)
            ->where("TIMESTAMPDIFF(MINUTE, reservas.fecha, NOW()) >", $minutes)
            ->findAll();
    }
}
