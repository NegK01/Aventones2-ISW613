<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_rol',
        'cedula',
        'nombre',
        'apellido',
        'nacimiento',
        'correo',
        'telefono',
        'fotografia',
        'contrasena',
        'id_estado',
        'token',
        'fechaDeRegistro',
    ];

    protected $useTimestamps = false;

    public function crearUsuario(array $data)//: int
    {
        $this->insert($data);
        // return (int) $this->getInsertID();
    }

    public function actualizarUsuario(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function actualizarEstado(int $idUsuario, int $idEstado): bool
    {
        return $this->update($idUsuario, [
            'id_estado' => $idEstado,
            'token'     => null,
        ]);
    }

    public function obtenerUsuarioPorId(int $idUsuario): ?array
    {
        return $this->select(
            'usuarios.id_usuario, usuarios.id_rol, roles.nombre AS rol, usuarios.cedula, usuarios.nombre,' .
            ' usuarios.apellido, usuarios.nacimiento, usuarios.correo, usuarios.telefono, usuarios.fotografia,' .
            ' usuarios.contrasena, usuarios.id_estado, estados.nombre AS estado, usuarios.token, usuarios.fechaDeRegistro'
        )
            ->join('roles', 'roles.id_rol = usuarios.id_rol', 'left')
            ->join('estados', 'estados.id_estado = usuarios.id_estado', 'left')
            ->where('usuarios.id_usuario', $idUsuario)
            ->first() ?: null;
    }

    public function obtenerTodos(?int $idEstado = null): array
    {
        $builder = $this->select(
            'usuarios.id_usuario, usuarios.nombre, usuarios.apellido, usuarios.correo,' .
            ' usuarios.id_rol, roles.nombre AS rol, usuarios.fechaDeRegistro,' .
            ' usuarios.id_estado, estados.nombre AS estado, usuarios.token'
        )
            ->join('roles', 'roles.id_rol = usuarios.id_rol', 'left')
            ->join('estados', 'estados.id_estado = usuarios.id_estado', 'left')
            ->orderBy('usuarios.id_usuario', 'ASC');

        if ($idEstado !== null && $idEstado !== 0) {
            $builder->where('usuarios.id_estado', $idEstado);
        }

        return $builder->findAll();
    }

    public function obtenerPorCorreo(string $correo): ?array
    {
        return $this->select('id_usuario, id_rol, contrasena, id_estado')
            ->where('correo', $correo)
            ->first() ?: null;
    }

    public function activarPorToken(string $token): ?string
    {
        $user = $this->select('correo')
            ->where('token', $token)
            ->where('id_estado', 2)
            ->first();

        if (empty($user)) {
            return null;
        }

        $this->where('token', $token)
            ->where('id_estado', 2)
            ->set(['id_estado' => 4, 'token' => null])
            ->update();

        return $user['correo'];
    }
}
