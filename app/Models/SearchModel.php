<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchModel extends Model
{
    protected $table = 'busquedas';
    protected $primaryKey = 'id_busqueda';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_usuario',
        'origen',
        'destino',
        'fechaHora',
        'resultados',
    ];

    protected $useTimestamps = false;

    public function crearHistorial(array $data): int
    {
        $this->insert($data, true);
        return (int) $this->getInsertID();
    }

    public function getSearches()
    {
        $builder = $this->select(
            "busquedas.*, DATE_FORMAT(busquedas.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, " .
            "usuarios.nombre, usuarios.apellido"
        )
            ->join('usuarios', 'usuarios.id_usuario = busquedas.id_usuario', 'left')
            ->orderBy('busquedas.fechaHora', 'DESC');

        return $builder->findAll();
    }
}
