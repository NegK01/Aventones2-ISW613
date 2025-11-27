<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\RideModel;
use CodeIgniter\API\ResponseTrait;

class ReservationController extends BaseController
{
    use ResponseTrait;

    protected $reservationModel;
    protected $rideModel;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
        $this->rideModel = new RideModel();
    }

    public function showReservation()
    {
        return view('reservation/reservations');
    }

    public function getAll()
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('idRole');

        $reservations = $this->reservationModel->obtenerReservasPorUsuario($userRole, $userId);

        return $this->respond([
            'success' => true,
            'reservations' => $reservations,
        ]);
    }

    public function store()
    {
        $clientId = session()->get('user_id');
        $rideId = $this->request->getPost('rideId');

        $ride = $this->rideModel->obtenerRidePorId($rideId);

        $driverId = $ride['id_usuario'];

        date_default_timezone_set('America/Costa_Rica');
        $fecha = date("Y-m-d H:i");

        $reservas = $this->reservationModel->obtenerReservaFiltrada($rideId, $clientId, $driverId);

        if ($reservas !== null) {
            return $this->respond(['error' => 'Ya existe una solicitud igual'], 404);
        }

        $data = [
            'id_ride'    => $rideId,
            'id_chofer'  => $driverId,
            'id_cliente' => $clientId,
            'fecha'      => $fecha,
            'id_estado'  => 2,
        ];

        $this->reservationModel->crearReserva($data);

        return $this->respond(['success' => 'Reservacion hecha correctamente correctamente']);
    }

    public function update()
    {
        $reservationId = (int) $this->request->getPost('reservationId');
        $reservationState  = $this->request->getPost('reservationState');

        $this->reservationModel->actualizarEstado($reservationId, $reservationState);

        return $this->respond(['success' => 'Solicitud hecha correctamente']);
    }

}