<?php

namespace App\Controllers;

use App\Libraries\FileUploader;
use App\Libraries\MailService;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    protected UserModel $userModel;
    protected FileUploader $fileUploader;
    protected MailService $mailService;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 
    // TODO quitar esto cuando intelephense deje de estar fallando

    public function __construct()
    {
        // helper(['url', 'form']);
        $this->userModel    = new UserModel();
        $this->fileUploader = new FileUploader('assets/userPhotos');
        $this->mailService  = new MailService();
    }

    // METODOS PARA MOSTRAR CON VIEWS
    // metodo para mostrar pagina de login como nuestra pagina inicial
    public function showLogin()
    {
        // if (session()->get('user_id')) {
        //     return redirect()->to(site_url('/'));
        // }

        return view('auth/login');
    }

    // metodo para mostrar pagina de registro 
    public function showRegister()
    {
        // if (session()->get('user_id')) {
        //     return redirect()->to(site_url('/'));
        // }

        return view('auth/register');
    }

    // metodo para mostrar pagina de verificacion
    public function showVerification()
    {
        return view('auth/verification');
    }

    public function showforgotPassword()
    {
        return view('auth/forgotPassword');
    }

    // metodo para realizar el registro de un usuario 
    public function register()
    {
        // if (!$this->request->is('post')) {
        //     return $this->respond(['error' => 'Metodo no permitido'], 405);
        // }

        // validaciones mediante reglas, todos los campos son requeridos para el registro
        $rules = [
            'roleId'                 => 'required|in_list[1,2,3]',
            'name'                   => 'required',
            'lastname'               => 'required',
            'id'                     => 'required',
            'birthdate'              => 'required',
            'email'                  => 'required|valid_email',
            'phone'                  => 'required',
            'password'               => 'required|min_length[3]',
            'password-confirmation'  => 'required|matches[password]',
        ];

        // se hace primero la validacion y despues la recoleccion, validate ya posee un getPost internamente para validar reglas
        if (!$this->validate($rules)) { // join por si hay mas de 1 error
            return $this->respond(['error' => implode('. ', $this->validator->getErrors())], 400);
        }

        $role    = (int) $this->request->getPost('roleId');
        $estado  = (int) ($this->request->getPost('statusId') ?? 2);
        $token   = $role == 1 ? null : bin2hex(random_bytes(16)); // si es admin (1), no ocupa token
        $photo   = $this->request->getFile('photo');
        $photoPath = null;

        // procesar la foto
        try {
            $photoPath = $this->fileUploader->upload($photo);
        } catch (\Throwable $e) {
            return $this->respond(['error' => $e->getMessage()], 400);
        }

        // recoleccion de los datos
        $userData = [
            'id_rol'      => $role,
            'cedula'      => trim($this->request->getPost('id')),
            'nombre'      => trim($this->request->getPost('name')),
            'apellido'    => trim($this->request->getPost('lastname')),
            'nacimiento'  => $this->request->getPost('birthdate'),
            'correo'      => strtolower(trim($this->request->getPost('email'))),
            'telefono'    => trim($this->request->getPost('phone')),
            'contrasena'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'id_estado'   => $estado,
            'token'       => $token,
        ];

        if ($photoPath !== null) {
            $userData['fotografia'] = $photoPath;
        }

        $this->userModel->crearUsuario($userData);

        if ($this->userModel->errors()) {
            return $this->respond(['error' => implode('. ', $this->userModel->errors())], 400);
        }

        if ($role !== 1) {
            $this->mailService->sendVerificationMail($userData);
            return $this->respond(['success' => 'Registro exitoso. Revisa tu email para confirmar tu cuenta.']);
        }

        return $this->respond(['success' => 'Registro exitoso, administrador creado correctamente.']);
    }

    // METODOS PARA EJECUTAR LA FUNCIONALIDAD DE LAS VISTAS
    // metodo para verificar el login
    public function login()
    {
        // if (!$this->request->is('post')) {
        //     return $this->respond(['error' => 'Metodo no permitido'], 405);
        // }

        $email    = strtolower(trim($this->request->getPost('email') ?? ''));
        $password = $this->request->getPost('password') ?? '';

        if (empty($email) || empty($password)) {
            return $this->respond(['error' => 'Todos los campos son obligatorios'], 400);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->respond(['error' => 'Correo invalido'], 400);
        }

        $usuario = $this->userModel->obtenerPorCorreo($email);
        if ($usuario === null) {
            return $this->respond(['error' => 'Credenciales incorrectas'], 400);
        }

        if ((int) $usuario['id_estado'] === 2) {
            return $this->respond(['error' => 'Cuenta pendiente de activación. Verifica tu correo.'], 400);
        }
        if ((int) $usuario['id_estado'] === 5) {
            return $this->respond(['error' => 'Cuenta suspendida. Contacta al administrador.'], 400);
        }
        if ((int) $usuario['id_estado'] !== 4) {
            return $this->respond(['error' => 'Estado de cuenta invalido. Contacta al administrador.'], 400);
        }

        if (!password_verify($password, $usuario['contrasena'])) {
            return $this->respond(['error' => 'Credenciales incorrectas'], 400);
        }

        // crear la session del usuario actual
        session()->set([
            'user_id' => (int) $usuario['id_usuario'],
            'idRole'  => (int) $usuario['id_rol'],
        ]);

        return $this->respond([
            'success' => 'Inicio de sesion exitoso. Redirigiendo...',
            'idRole'  => (int) $usuario['id_rol'],
        ]);
    }

    // metodo para cerrar sesion del usuario actual
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }

    // metodo para verificar cuenta
    public function verifyAccount()
    {
        // if (!$this->request->is('get')) {
        //     return $this->respond(['error' => 'Metodo no permitido'], 405);
        // }

        $token = trim((string) $this->request->getGet('token'));
        if (empty($token)) {
            return $this->respond(['error' => 'No se envio ningun token'], 400);
        }

        $email = $this->userModel->activarPorToken($token);

        if ($email) {
            return $this->respond([
                'success' => true,
                'email'   => $email,
            ]);
        }

        return $this->respond([
            'success' => false,
            'error'   => 'No se encontro el token enviado',
        ], 400);
    }
    public function sendPasswordLessEmail()
    {
        $email    = strtolower(trim($this->request->getPost('email') ?? ''));
        if (empty($email)) {
            return $this->respond(['error' => 'El correo es obligatorio.'], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->respond(['error' => 'Correo invalido'], 400);
        }

        $usuario = $this->userModel->obtenerPorCorreo($email); // obtener el usuario segun correo, solo trae ids
        if ($usuario === null) {
            return $this->respond(['error' => 'No se pudo encontrar una cuenta con el correo proporcionado.'], 404);
        }

        if ((int) $usuario['id_estado'] !== 4) {
            return $this->respond(['error' => 'Tu cuenta esta inactiva. Contacta a un administrador.'], 400);
        }

        $token = bin2hex(random_bytes(16));
        $saved = $this->userModel->actualizarUsuario((int) $usuario['id_usuario'], [
            'tokenNoPassword' => $token,
        ]);

        if (!$saved) {
            return $this->respond(['error' => 'No se pudo preparar el enlace de acceso. Intenta nuevamente.'], 500);
        }

        $usuario['correo'] = $email;
        $usuario['tokenNoPassword'] = $token;

        if ($this->mailService->sendPasswordLessEmail($usuario)) {
            return $this->respond(['success' => 'Enlace de acceso enviado correctamente. Revisa tu correo.']);
        }

        return $this->respond(['error' => 'No se pudo enviar el email. Intenta nuevamente.'], 500);
    }

    // metodo para iniciar sesion sin password
    public function verifyPasswordLess()
    {
        $token = trim((string) $this->request->getGet('token')); // obtener token de la url
        if (empty($token)) {
            // return $this->respond(['error' => 'No se envio ningun token'], 400);
            return redirect()->to(site_url('forgotPassword'))->with('error', 'Enlace invalido.');
        }

        // obtener el correo segun el token, tambien se limpia el campo del token de less password una vez utilizado
        $email = $this->userModel->loginPasswordLess($token);
        if ($email === null) {
            return redirect()->to(site_url('forgotPassword'))->with('error', 'El enlace ya fue utilizado o expiro.');
        }

        $usuario = $this->userModel->obtenerPorCorreo($email); // obtener el usuario segun correo
        if ($usuario === null) {
            return redirect()->to(site_url('forgotPassword'))->with('error', 'No encontramos la cuenta asociada al enlace.');
        }

        // crear la session del usuario 
        session()->set([
            'user_id' => (int) $usuario['id_usuario'],
            'idRole'  => (int) $usuario['id_rol'],
        ]);

        // admin posee un home llamado dashboard, el home de choferes y pasajeros es search
        $redirectPath = (int) $usuario['id_rol'] === 1 ? 'dashboard' : 'search';

        return redirect()->to(site_url($redirectPath));
    }
}
