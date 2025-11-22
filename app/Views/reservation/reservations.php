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
                                <tbody id="reserves-tbody">
                                    <tr>
                                        <td>Viaje a la Universidad</td>
                                        <td>18/05/2025 08:00</td>
                                        <td>Cumbayá</td>
                                        <td>USFQ</td>
                                        <td>Juan Pérez</td>
                                        <td>Toyota Corolla (2020)</td>
                                        <td><span class="badge green-badge">Confirmado</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="details" class="btn btn-secondary btn-none-decoration">Detalles</a>
                                                <button class="btn btn-secondary">Cancelar</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Viaje de regreso a casa</td>
                                        <td>18/05/2025 17:00</td>
                                        <td>USFQ</td>
                                        <td>Cumbayá</td>
                                        <td>Juan Pérez</td>
                                        <td>Toyota Corolla (2020)</td>
                                        <td><span class="badge yellow-badge">Pendiente</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="rideDetails" class="btn btn-secondary btn-none-decoration">Detalles</a>
                                                <button class="btn btn-secondary">Cancelar</button>
                                            </div>
                                        </td>
                                    </tr>
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
                                <tbody id="reserves-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <form id="reserve-form" method="post" action="rideDetails.php" hidden>
                <input type="hidden" name="rideId">
                <input type="hidden" name="reserveId">
                <input type="hidden" name="reserveState">
                <input type="hidden" name="userRole" value">
            </form> -->
        </main>
    </div>
    <script src="../js/mostrarMensaje.js"></script>
    <script src="../js/reserve/reserve.js"></script>
</body>

</html>