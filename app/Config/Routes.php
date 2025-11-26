<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'authFilter'], function ($routes) {
    // COMPARTIDO (Guest - Admin - Driver - Passenger)
    $routes->get('search',         'RideController::showSearch',             ['roles' => ['guest', 'driver', 'passenger']]);
    $routes->get('auth/logout',    'AuthController::logout',                 ['roles' => ['admin', 'driver', 'passenger']]);
    $routes->post('auth/register', 'AuthController::register',               ['roles' => ['guest', 'admin']]);
    $routes->get('reservations',   'ReservationController::showReservation', ['roles' => ['driver', 'passenger']]);
    $routes->get('details',        'RideController::showDetails',            ['roles' => ['driver', 'passenger']]);
    $routes->post('ride/search',   'RideController::search',                 ['roles' => ['guest', 'driver', 'passenger']]);
    // Relacionado a profile
    $routes->get('profile',             'UserController::showProfile', ['roles' => ['driver', 'passenger']]);
    $routes->get('profile/information', 'UserController::currentUser', ['roles' => ['driver', 'passenger']]);
    $routes->post('profile/update',     'UserController::update',      ['roles' => ['driver', 'passenger']]);

    // GUEST
    $routes->get('/',              'AuthController::showLogin',        ['roles' => ['guest']]);
    $routes->get('login',          'AuthController::showLogin',        ['roles' => ['guest']]);
    $routes->get('register',       'AuthController::showRegister',     ['roles' => ['guest']]);
    $routes->get('verification',   'AuthController::showVerification', ['roles' => ['guest']]);
    // Funcionalidades
    $routes->post('auth/login',       'AuthController::login',         ['roles' => ['guest']]);
    $routes->get('auth/verification', 'AuthController::verifyAccount', ['roles' => ['guest']]);

    // ADMIN
    $routes->get('dashboard',      'UserController::showDashboard',    ['roles' => ['admin']]);
    $routes->get('adminForm',      'UserController::showAdminForm',    ['roles' => ['admin']]);
    // Funcionalidades
    $routes->post('user/status',   'UserController::changeStatus',     ['roles' => ['admin']]);
    $routes->post('user/users',     'UserController::allUsers',        ['roles' => ['admin']]);

    // DRIVER
    $routes->get('rides',           'RideController::showRide',           ['roles' => ['driver']]);
    $routes->get('vehicles',        'VehicleController::showVehicle',     ['roles' => ['driver']]);
    $routes->match(['get', 'post'], 'rideForm',       'RideController::showRideForm',       ['roles' => ['driver']]);
    $routes->match(['get', 'post'], 'vehicleForm',    'VehicleController::showVehicleForm', ['roles' => ['driver']]);
    // Funcionalidades
    $routes->get('vehicle/getAll',  'VehicleController::getAll',         ['roles' => ['driver']]);
    $routes->get('ride/getAll',     'RideController::getAll',            ['roles' => ['driver']]);
    $routes->get('vehicle/listForDropdown', 'VehicleController::listForDropdown',  ['roles' => ['driver']]);
    $routes->post('vehicle/getById','VehicleController::getVehicleById', ['roles' => ['driver']]);
    $routes->post('vehicle/store',  'VehicleController::store',          ['roles' => ['driver']]);
    $routes->post('vehicle/update', 'VehicleController::update',         ['roles' => ['driver']]);
    $routes->post('vehicle/delete', 'VehicleController::delete',         ['roles' => ['driver']]);
    $routes->post('ride/getById',   'RideController::getRideById',       ['roles' => ['driver']]);
    $routes->post('ride/store',     'RideController::store',             ['roles' => ['driver']]);
    $routes->post('ride/update',    'RideController::update',            ['roles' => ['driver']]);
    $routes->post('ride/delete',    'RideController::delete',            ['roles' => ['driver']]);

    // PASSENGER
    // Funcionalidades
});
