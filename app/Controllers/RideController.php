<?php

namespace App\Controllers;

use App\Models\RideModel;
use App\Models\SearchModel;
use App\Models\VehicleModel;
use CodeIgniter\API\ResponseTrait;

class RideController extends BaseController
{
    use ResponseTrait;

    protected $rideModel;
    protected $vehicleModel;
    protected $searchModel;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 

    public function __construct()
    {
        $this->rideModel = new RideModel();
        $this->vehicleModel = new VehicleModel();
        $this->searchModel = new SearchModel();
    }

    public function showSearch()
    {
        return view('ride/search');
    }

    public function showRide()
    {
        return view('ride/rides');
    }

    public function showRideForm()
    {
        $rideId = $this->request->getPost('rideId');

        return view('ride/rideForm', [
            'rideId' => $rideId
        ]);
    }

    public function showDetails()
    {

        $rideId = $this->request->getPost('rideId');
        $userRole = $this->request->getPost('userRole');

        return view('ride/details', [
            'rideId' => $rideId,
            '$userRole' => $userRole,
        ]);
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

    public function getRideById()
    {
        $rideId = (int) $this->request->getPost('rideId');
        $userId = session()->get('user_id');

        $ride = $this->rideModel->obtenerRidePorId($rideId);
        $vehicles = $this->vehicleModel->obtenerVehiculosActivosPorUsuario($userId);

        return $this->respond([
            'success' => true,
            'ride' => $ride,
            'vehicles' => $vehicles
        ]);
    }

    public function search()
    {
        $origin = $this->request->getPost('search-origin');
        $destination = $this->request->getPost('search-destination');

        $filters = [
            'origin' => $origin,
            'destination' => $destination
        ];

        $rides = $this->rideModel->getRides($filters);

        $results = count($rides);

        if (array_filter($filters)) {
            $this->saveSearch($origin, $destination, $results);
        }

        return $this->respond([
            'success' => true,
            'rides' => $rides
        ]);
    }

    public function saveSearch($origin, $destination, $results)
    {
        $userId = session()->get('user_id') ?? null;

        $origin = trim($origin) ?: null;
        $destination = trim($destination) ?: null; 

        date_default_timezone_set('America/Costa_Rica');
        $fechaHora = date("Y-m-d H:i");

        $data = [
            'id_usuario' => $userId,
            'origen' => $origin,
            'destino' => $destination,
            'fechaHora' => $fechaHora,
            'resultados' => $results,
        ];

        $this->searchModel->crearHistorial($data);
    }

    public function getSearches()
    {
        $searches = $this->searchModel->getSearches();

        return $this->respond([
            'success' => true,
            'searches' => $searches,
        ]);
    }

    public function store()
    {
        $userId = session()->get('user_id');

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

        $idVehiculo = (int) $this->request->getPost('id_vehiculo');
        $asientos = (int) $this->request->getPost('asientos');
        $capacidadVehiculo = $this->vehicleModel->obtenerCapacidadVehiculo($idVehiculo);

        if ($capacidadVehiculo === null) {
            return $this->respond(['error' => 'El vehiculo seleccionado no existe o no pertenece al usuario'], 404);
        }

        $capacidadDisponible = max(0, $capacidadVehiculo - 1); // se le resta el conductor

        if ($asientos <= 0) {
            return $this->respond(['error' => 'La cantidad de espacios disponibles debe ser mayor a cero'], 400);
        }

        if ($capacidadDisponible === 0) {
            return $this->respond(['error' => 'El vehiculo no tiene espacios disponibles para pasajeros'], 400);
        }

        if ($asientos > $capacidadDisponible) {
            return $this->respond([
                'error' => sprintf(
                    'La cantidad de espacios indicados (%d) supera la capacidad del vehiculo (%d, restando al conductor)',
                    $asientos,
                    $capacidadDisponible
                )
            ], 400);
        }

        $data = [
            'id_usuario' => $userId,
            'nombre' => $this->request->getPost('rideName'),
            'origen' => $this->request->getPost('origen'),
            'destino' => $this->request->getPost('destino'),
            'fechaHora' => $this->request->getPost('fecha_hora'),
            'costoAsiento' => $this->request->getPost('costoAsiento'),
            'id_vehiculo' => $idVehiculo,
            'asientos' => $asientos,
            'detalles' => $this->request->getPost('detalles'),
            'id_estado' => 4 // Active
        ];

        $this->rideModel->insert($data);

        return $this->respond(['success' => 'Ride publicado correctamente']);
    }

    public function update()
    {
        $rideId = $this->request->getPost('rideId');
        $userId = session()->get('user_id');

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

        $idVehiculo = (int) $this->request->getPost('id_vehiculo');
        $asientos = (int) $this->request->getPost('asientos');
        $capacidadVehiculo = $this->vehicleModel->obtenerCapacidadVehiculo($idVehiculo);

        if ($capacidadVehiculo === null) {
            return $this->respond(['error' => 'El vehiculo seleccionado no existe o no pertenece al usuario'], 404);
        }

        $capacidadDisponible = max(0, $capacidadVehiculo - 1); // se le resta el conductor

        if ($asientos <= 0) {
            return $this->respond(['error' => 'La cantidad de espacios disponibles debe ser mayor a cero'], 400);
        }

        if ($capacidadDisponible === 0) {
            return $this->respond(['error' => 'El vehiculo no tiene espacios disponibles para pasajeros'], 400);
        }

        if ($asientos > $capacidadDisponible) {
            return $this->respond([
                'error' => sprintf(
                    'La cantidad de espacios indicados (%d) supera la capacidad del vehiculo (%d, restando al conductor)',
                    $asientos,
                    $capacidadDisponible
                )
            ], 400);
        }

        $data = [
            'id_usuario' => $userId,
            'nombre' => $this->request->getPost('rideName'),
            'origen' => $this->request->getPost('origen'),
            'destino' => $this->request->getPost('destino'),
            'fechaHora' => $this->request->getPost('fecha_hora'),
            'costoAsiento' => $this->request->getPost('costoAsiento'),
            'id_vehiculo' => $idVehiculo,
            'asientos' => $asientos,
            'detalles' => $this->request->getPost('detalles'),
            'id_estado' => 4 // Active
        ];

        $this->rideModel->actualizarRide($rideId, $data);

        return $this->respond(['success' => 'Ride editado correctamente']);
    }

    public function delete()
    {
        $rideId = (int) $this->request->getPost('rideId');

        $this->rideModel->eliminarRide($rideId);
        return $this->respond(['success' => true]);
    }
}
