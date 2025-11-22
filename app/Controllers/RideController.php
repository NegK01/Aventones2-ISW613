<?php

namespace App\Controllers;

use App\Models\RideModel;
use App\Models\VehicleModel;
use CodeIgniter\API\ResponseTrait;

class RideController extends BaseController
{
    use ResponseTrait;

    protected $rideModel;
    protected $vehicleModel;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 

    public function __construct()
    {
        $this->rideModel = new RideModel();
        $this->vehicleModel = new VehicleModel();
    }

    public function showSearch()
    {
        return view('ride/search');
    }

    public function showRide()
    {
        return view('ride/rides');
    }

    public function showDetails()
    {
        return view('ride/details');
    }

    public function getAll()
    {
        $userId = session()->get('user_id');

        $rides = $this->rideModel->obtenerRidesPorUsuario($userId);

        return $this->respond([
            'success' => true,
            'rides' => $rides
        ]);
    }

    public function search()
    {
        $origin = $this->request->getGet('origin');
        $destination = $this->request->getGet('destination');
        $sort = $this->request->getGet('sort') ?? 'date-asc';

        $filters = [
            'origin' => $origin,
            'destination' => $destination
        ];

        $rides = $this->rideModel->getRides($filters, $sort);

        return $this->respond([
            'success' => true,
            'rides' => $rides
        ]);
    }

    public function create()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $vehicles = $this->vehicleModel->getVehiclesByUser($userId);
        return view('rides/create', ['vehicles' => $vehicles]);
    }

    public function store()
    {
        $userId = session()->get('user_id');
        // if (!$userId) {
        //     return $this->respond(['error' => 'Usuario no autenticado'], 401);
        // }

        $rules = [
            'rideName' => 'required',
            'origen' => 'required',
            'destino' => 'required',
            'fecha_hora' => 'required',
            'costoAsiento' => 'required|numeric',
            'asientos' => 'required|integer',
            'id_vehiculo' => 'required|integer',
            'detalles' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->respond(['error' => implode('. ', $this->validator->getErrors())], 400);
        }

        $data = [
            'nombre' => $this->request->getPost('rideName'),
            'origen' => $this->request->getPost('origen'),
            'destino' => $this->request->getPost('destino'),
            'fecha_hora' => $this->request->getPost('fecha_hora'),
            'costo' => $this->request->getPost('costoAsiento'),
            'asientos' => $this->request->getPost('asientos'),
            'id_vehiculo' => $this->request->getPost('id_vehiculo'),
            'detalles' => $this->request->getPost('detalles'),
            'id_estado' => 1 // Active
        ];

        $this->rideModel->insert($data);

        return $this->respond(['success' => 'Ride publicado correctamente']);
    }
}
