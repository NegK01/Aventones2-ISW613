<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id_vehiculo';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_usuario',
        'placa',
        'color',
        'marca',
        'modelo',
        'anio',
        'asientos',
        'fotografia',
        'id_estado',
    ];

    protected $useTimestamps = false;

    protected array $fieldAliases = [
        'capacidad' => 'asientos',
    ];

    public function crearVehiculo(array $data): int
    {
        $this->insert($data, true);
        return (int) $this->getInsertID();
    }

    public function getVehiclesByUser(int $userId): array
    {
        return $this->obtenerVehiculosPorUsuario($userId);
    }

    public function actualizarVehiculo(int $vehicleId, array $data): bool
    {
        return $this->update($vehicleId, $data);
    }

    public function eliminarVehiculo(int $vehicleId): bool
    {
        return $this->where('id_vehiculo', $vehicleId)
            ->set('id_estado', 5)
            ->update();
    }

    public function obtenerVehiculosPorUsuario(int $userId): array
    {
        return $this->select('vehiculos.*, estados.nombre AS estado')
            ->join('estados', 'estados.id_estado = vehiculos.id_estado', 'left')
            ->where('vehiculos.id_usuario', $userId)
            ->orderBy('vehiculos.id_estado', 'ASC')
            ->orderBy('vehiculos.id_vehiculo', 'ASC')
            ->findAll();
    }

    public function obtenerVehiculoPorId(int $vehicleId): ?array
    {
        return $this->where('id_vehiculo', $vehicleId)->first() ?: null;
    }

    public function obtenerCapacidadVehiculo(int $vehicleId): ?int
    {
        $vehiculo = $this->select('asientos')
            ->where('id_vehiculo', $vehicleId)
            ->first();

        return $vehiculo['asientos'] ?? null;
    }
}
