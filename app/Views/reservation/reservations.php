<?php
// Desde aca obtenemos el valor del rol para agregarlo a el form con informacion
$userRole = $_SESSION['idRole'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Reservas</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/tables.css">
    <link rel="stylesheet" href="../css/components/tabs.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header.php', ['activePage' => 'reservations']) ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Mis Reservas</h2>
                </div>
                <div class="section-content">
                    <div class="tabs">
                        <button class="tab active" data-tab="active-reservations">Activas</button>
                        <button class="tab" data-tab="past-reservations">Pasadas</button>
                    </div>
                    <div id="active-reservations" class="tab-content active">
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Ride</th>
                                        <th>Fecha/Hora</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Chofer</th>
                                        <th>Vehículo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="reservations-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="past-reservations" class="tab-content">
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Ride</th>
                                        <th>Fecha/Hora</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Chofer</th>
                                        <th>Vehículo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="reservations-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <form id="reservation-form" method="post" action="details" hidden>
                <input type="hidden" name="rideId">
                <input type="hidden" name="reservationId">
                <input type="hidden" name="reservationState">
                <input type="hidden" name="userRole" value="<?= htmlspecialchars($userRole) ?>">
            </form>
        </main>
    </div>
    <script src="../js/mostrarMensaje.js"></script>
    <script src="../js/reservation/reservation.js"></script>
</body>

</html>