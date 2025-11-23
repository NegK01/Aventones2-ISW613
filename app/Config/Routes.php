<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'authFilter'], function ($routes) {
    // COMPARTIDO (Guest - Admin - Driver - Passenger)
    $routes->get('search',         'RideController::showSearch',             ['roles' => ['guest', 'driver', 'passenger']]);
    $routes->get('auth/logout',    'AuthController::logout',                 ['roles' => ['admin', 'driver', 'passenger']]);
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
    $routes->post('auth/login',       'AuthController::login',            ['roles' => ['guest']]);
    $routes->post('auth/register',    'AuthController::register',         ['roles' => ['guest']]);
    $routes->get('auth/verification', 'AuthController::verifyAccount',    ['roles' => ['guest']]);

    // ADMIN
    $routes->get('dashboard',      'UserController::showDashboard',    ['roles' => ['admin']]);
    $routes->get('adminForm',      'UserController::showAdminForm',    ['roles' => ['admin']]);
    // Funcionalidades
    $routes->post('user/status',   'UserController::changeStatus',     ['roles' => ['admin']]);
    $routes->get('user/users',     'UserController::allUsers',         ['roles' => ['admin']]);

    // DRIVER
    $routes->get('rides',          'RideController::showRide',         ['roles' => ['driver']]);
    $routes->get('vehicles',       'VehicleController::showVehicle',   ['roles' => ['driver']]);
    // Funcionalidades
    $routes->get('vehicle/getAll', 'VehicleController::getAll',        ['roles' => ['driver']]);
    $routes->get('ride/getAll',    'RideController::getAll',        ['roles' => ['driver']]);

    // PASSENGER
    // Funcionalidades
});
