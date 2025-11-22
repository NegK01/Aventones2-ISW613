<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Obtener los roles permitidos por la ruta
        $routeOptions = service('router')->getMatchedRouteOptions();
        $allowedRoles = $routeOptions['roles'] ?? [];

        // Obtener rol actual del usuario 
        $idRole = $session->get('idRole'); // 1=admin, 2=driver, 3=passenger

        // Mapear roles numéricos a texto
        $roleMap = [
            1 => 'admin',
            2 => 'driver',
            3 => 'passenger'
        ];

        $currentRole = $roleMap[$idRole] ?? null;

        // USUARIO NO LOGUEADO (guest)
        if (!$currentRole) {

            // ¿La ruta permite guest?
            if (in_array('guest', $allowedRoles)) {
                return; // permitir
            }

            // Ruta NO permite guest → redirigir a login
            return redirect()->to('/login');
        }

        // ==========================================================
        // CASO B: USUARIO LOGUEADO
        // ==========================================================

        // Si su rol NO está permitido → al home
        if (!in_array($currentRole, $allowedRoles)) {
            switch ($currentRole) {
                case 'admin':
                    return redirect()->to('dashboard');
                    break;
                case 'driver':
                    return redirect()->to('search');
                    break;
                case 'passenger':
                    return redirect()->to('search');
                    break;
                default:
                    return redirect()->to('/');
                    break;
            }
        }

        // Si está permitido → dejarlo pasar
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
