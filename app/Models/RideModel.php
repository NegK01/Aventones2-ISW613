<?php

namespace App\Models;

use CodeIgniter\Model;

class RideModel extends Model
{
    protected $table = 'rides';
    protected $primaryKey = 'id_ride';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_usuario',
        'id_vehiculo',
        'nombre',
        'origen',
        'destino',
        'fechaHora',
        'asientos',
        'costoAsiento',
        'detalles',
        'id_estado'
    ];

    protected $useTimestamps = false;

    public function crearRide(array $data): int
    {
        $this->insert($data, true);
        return (int) $this->getInsertID();
    }

    public function actualizarRide(int $rideId, array $data): bool
    {
        return $this->update($rideId, $data);
    }

    public function eliminarRide(int $rideId): bool
    {
        return $this->where('id_ride', $rideId)
            ->set('id_estado', 5)
            ->update();
    }

    public function obtenerRidesPorUsuario(int $userId): array
    {
        return $this->select("rides.*, DATE_FORMAT(rides.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, vehiculos.marca, vehiculos.modelo, vehiculos.anio")
            ->join('vehiculos', 'vehiculos.id_vehiculo = rides.id_vehiculo')
            ->where('rides.id_usuario', $userId)
            ->where('rides.id_estado', 4)
            ->findAll();
    }

    public function obtenerRidePorId(int $rideId): ?array
    {
        $ride = $this->select(
            "rides.*, DATE_FORMAT(rides.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, " .
                "vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.color, usuarios.fotografia, " .
                "usuarios.nombre AS nombreUsuario, usuarios.apellido AS apellidoUsuario"
        )
            ->join('vehiculos', 'vehiculos.id_vehiculo = rides.id_vehiculo')
            ->join('usuarios', 'usuarios.id_usuario = rides.id_usuario')
            ->where('rides.id_ride', $rideId)
            ->first();

        return $ride ?: null;
    }

    public function obtenerRidesFiltrados(?string $origen = null, ?string $destino = null): array
    {
        $builder = $this->select(
            "rides.*, DATE_FORMAT(rides.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, " .
                "vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.color"
        )
            ->join('vehiculos', 'vehiculos.id_vehiculo = rides.id_vehiculo')
            ->where('rides.id_estado', 4);

        if (!empty($origen)) {
            $builder->where('rides.origen', $origen);
        }

        if (!empty($destino)) {
            $builder->where('rides.destino', $destino);
        }

        return $builder->findAll();
    }

    public function getRides($filters = [])
    {
        $builder = $this->select(
            "rides.*, DATE_FORMAT(rides.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, " .
                "vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.fotografia AS vehiculo_foto"
        )
            ->join('vehiculos', 'vehiculos.id_vehiculo = rides.id_vehiculo')
            ->where('rides.id_estado', 4);

        if (!empty($filters['origin'])) {
            $builder->like('rides.origen', $filters['origin']);
        }

        if (!empty($filters['destination'])) {
            $builder->like('rides.destino', $filters['destination']);
        }

        return $builder->findAll();
    }
}
