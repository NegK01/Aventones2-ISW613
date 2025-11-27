<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use CodeIgniter\API\ResponseTrait;

class ReservationController extends BaseController
{
    use ResponseTrait;

    protected $reservationModel;
    protected $request; // esto ya CI lo maneja internamente en el BaseController pero intelephense muestra un error visual de que no lo pudo encontrar, entonces se le pone la variable pero no tiene ningun efecto real, 


    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
    }

    public function showReservation()
    {
        // $userId = session()->get('user_id');
        // $vehicles = $this->reservationModel->getVehiclesByUser($userId);
        return view('reservation/reservations');
    }
}