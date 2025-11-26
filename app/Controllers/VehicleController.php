<?php

namespace App\Controllers;

use App\Libraries\FileUploader;
use App\Models\VehicleModel;
use CodeIgniter\API\ResponseTrait;

class VehicleController extends BaseController
{
    use ResponseTrait;

    protected $vehicleModel;
    protected $fileUploader;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 


    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
        $this->fileUploader = new FileUploader('assets/vehiclePhotos');

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/');
        }
    }

    public function showVehicle()
    {
        return view('vehicle/vehicles');
    }   

    public function showVehicleForm()
    {
        $vehicleId = $this->request->getPost('vehicleId');

        
        return view('vehicle/vehicleForm', [
            'vehicleId' => $vehicleId
        ]);
    }

    public function getAll()
    {
        $userId = session()->get('user_id');
        $vehicles = $this->vehicleModel->obtenerVehiculosPorUsuario($userId);

        return $this->respond([
            'success' => true,
            'vehicles' => $vehicles
        ]);
    }

    public function getVehicleById()
    {
            $vehicleId = (int) $this->request->getPost('vehicleId');
            $vehicle = $this->vehicleModel->obtenerVehiculoPorId($vehicleId);

            return $this->respond([
                'success' => true,
                'vehicle' => $vehicle
            ]);
    }

    public function store()
    {
        $userId = session()->get('user_id');
        // if (!$userId) {
        //     return $this->respond(['error' => 'Usuario no autenticado'], 401);
        // }

        $rules = [
            'vehicleBrand' => 'required',
            'vehicleModel' => 'required',
            'vehicleYear' => 'required|integer',
            'vehicleColor' => 'required',
            'vehiclePlate' => 'required',
            'vehicleSeats' => 'required|integer',
            'vehicleStatus' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->respond(['error' => implode('. ', $this->validator->getErrors())], 400);
        }

        $photo = $this->request->getFile('vehiclePhoto');
        $photoPath = null;

        try {
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $photoPath = $this->fileUploader->upload($photo);
            }
        } catch (\Throwable $e) {
            return $this->respond(['error' => $e->getMessage()], 400);
        }

        $data = [
            'marca' => $this->request->getPost('vehicleBrand'),
            'modelo' => $this->request->getPost('vehicleModel'),
            'anio' => $this->request->getPost('vehicleYear'),
            'color' => $this->request->getPost('vehicleColor'),
            'placa' => $this->request->getPost('vehiclePlate'),
            'asientos' => $this->request->getPost('vehicleSeats'),
            'id_estado' => $this->request->getPost('vehicleStatus'),
            'id_usuario' => $userId,
            'fotografia' => $photoPath
        ];

        $this->vehicleModel->crearVehiculo($data);

        return $this->respond(['success' => 'Vehiculo guardado correctamente']);
    }

    public function update()
    {
        $vehicleId = (int) $this->request->getPost('vehicleId');
        $userId = session()->get('user_id');
        // if (!$userId) {
        //     return $this->respond(['error' => 'Usuario no autenticado'], 401);
        // }

        $rules = [
            'vehicleBrand' => 'required',
            'vehicleModel' => 'required',
            'vehicleYear' => 'required|integer',
            'vehicleColor' => 'required',
            'vehiclePlate' => 'required',
            'vehicleSeats' => 'required|integer',
            'vehicleStatus' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->respond(['error' => implode('. ', $this->validator->getErrors())], 400);
        }

        $photo = $this->request->getFile('vehiclePhoto');
        $photoPath = null;

        try {
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $photoPath = $this->fileUploader->upload($photo);
            }
        } catch (\Throwable $e) {
            return $this->respond(['error' => $e->getMessage()], 400);
        }

        $data = [
            'marca' => $this->request->getPost('vehicleBrand'),
            'modelo' => $this->request->getPost('vehicleModel'),
            'anio' => $this->request->getPost('vehicleYear'),
            'color' => $this->request->getPost('vehicleColor'),
            'placa' => $this->request->getPost('vehiclePlate'),
            'asientos' => $this->request->getPost('vehicleSeats'),
            'id_estado' => $this->request->getPost('vehicleStatus'),
            'id_usuario' => $userId,
            'fotografia' => $photoPath
        ];

        $this->vehicleModel->actualizarVehiculo($vehicleId, $data);

        return $this->respond(['success' => 'Vehiculo guardado correctamente']);
    }

    public function delete()
    {
        $vehicleId = (int) $this->request->getPost('vehicleId');

        $this->vehicleModel->eliminarVehiculo($vehicleId);
        return $this->respond(['success' => true]);
    }

    public function listForDropdown()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->respond(['error' => 'Usuario no autenticado'], 401);
        }

        $vehicles = $this->vehicleModel->obtenerVehiculosActivosPorUsuario($userId);
        return $this->respond(['success' => true, 'vehicles' => $vehicles]);
    }
}
