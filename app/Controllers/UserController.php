<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\FileUploader;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    protected UserModel $userModel;
    protected FileUploader $fileUploader;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->fileUploader = new FileUploader('assets/userPhotos');
    }

    public function showDashboard()
    {
        return view('admin/dashboard');
    }

    public function showAdminForm()
    {
        return view('admin/adminForm');
    }

    public function showReports()
    {
        return view('admin/reports');
    }

    public function showProfile()
    {
        return view('user/profile');
    }

    // metodo para actualizar el perfil del usuario actual
    public function update()
    {
        // if (!$this->request->is('post')) {
        //     return $this->respond(['error' => 'Metodo no permitido'], 405);
        // }

        $idUsuario = (int) session()->get('user_id');
        if (!$idUsuario) {
            return $this->respond(['error' => 'Usuario no autenticado'], 401);
        }

        $rules = [
            'profile-firstname' => 'required',
            'profile-lastname'  => 'required',
            'profile-id'        => 'required',
            'profile-birthdate' => 'required',
            'profile-email'     => 'required|valid_email',
            'profile-phone'     => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->respond(['error' => implode('. ', $this->validator->getErrors())], 400);
        }

        $usuarioActual = $this->userModel->obtenerUsuarioPorId($idUsuario);
        if (!$usuarioActual) {
            return $this->respond(['error' => 'Usuario no encontrado'], 404);
        }

        $passwordHash      = $usuarioActual['contrasena'];
        $currentPassword   = $this->request->getPost('profile-current-password');
        $newPassword       = $this->request->getPost('profile-new-password');
        $passwordConfirm   = $this->request->getPost('profile-confirm-password');

        if (!empty($currentPassword) || !empty($newPassword) || !empty($passwordConfirm)) {
            if (empty($currentPassword) || empty($newPassword) || empty($passwordConfirm)) {
                return $this->respond(['error' => 'Todos los campos para cambiar la contraseña son obligatorios'], 400);
            }
            if (strlen((string) $newPassword) < 3) {
                return $this->respond(['error' => 'La contrasena debe tener al menos 3 caracteres'], 400);
            }
            if (!password_verify((string) $currentPassword, $passwordHash)) {
                return $this->respond(['error' => 'Contraseña actual incorrecta'], 400);
            }
            if ($newPassword !== $passwordConfirm) {
                return $this->respond(['error' => 'Las contrasenas no coinciden'], 400);
            }

            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $photo     = $this->request->getFile('photo');
        $photoPath = $usuarioActual['fotografia'] ?? null;

        try {
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $this->fileUploader->delete($photoPath);
                $photoPath = $this->fileUploader->upload($photo);
            }
        } catch (\Throwable $e) {
            return $this->respond(['error' => $e->getMessage()], 400);
        }

        $datosActualizados = [
            'cedula'     => trim($this->request->getPost('profile-id')),
            'nombre'     => trim($this->request->getPost('profile-firstname')),
            'apellido'   => trim($this->request->getPost('profile-lastname')),
            'nacimiento' => $this->request->getPost('profile-birthdate'),
            'correo'     => strtolower(trim($this->request->getPost('profile-email'))),
            'telefono'   => trim($this->request->getPost('profile-phone')),
            'contrasena' => $passwordHash,
        ];

        if ($photoPath !== null) {
            $datosActualizados['fotografia'] = $photoPath;
        }

        $this->userModel->actualizarUsuario($idUsuario, $datosActualizados);

        return $this->respond(['success' => 'Usuario actualizado correctamente']);
    }

    // metodo para cambiar el estado del usuario actual 
    public function changeStatus()
    {
        // if (!$this->request->is('post')) {
        //     return $this->respond(['error' => 'Metodo no permitido'], 405);
        // }

        $idUsuario = (int) $this->request->getPost('userId');
        $idEstado  = (int) $this->request->getPost('statusId');

        if (!$idUsuario || !$idEstado) {
            return $this->respond(['error' => 'Todos los campos son obligatorios'], 400);
        }

        $this->userModel->actualizarEstado($idUsuario, $idEstado);

        return $this->respond(['success' => 'Estado del usuario actualizado correctamente']);
    }

    // metodo para obtener toda la informacion del usuario
    public function currentUser()
    {
        $idUsuario = (int) session()->get('user_id');
        if (!$idUsuario) {
            return $this->respond(['error' => 'Usuario no autenticado'], 401);
        }

        $usuario = $this->userModel->obtenerUsuarioPorId($idUsuario);
        if (!$usuario) {
            return $this->respond(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario['fotografia'] = $usuario['fotografia']
            ? base_url($usuario['fotografia'])
            : null;

        return $this->respond([
            'success' => true,
            'user'    => $usuario,
        ]);
    }

    // metodo para obtener todos los usuarios para el dashboard de administrador
    public function allUsers()
    {
        $estado = $this->request->getPost('statusId');
        $estado = $estado !== null ? (int) $estado : null;

        $usuarios = $this->userModel->obtenerTodos($estado);

        return $this->respond([
            'success' => true,
            'users'   => $usuarios,
        ]);
    }
}
