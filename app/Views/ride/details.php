
<?php
$rideId = $_POST['rideId'] ?? null;
$isReservationMode = $_POST['userRole'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Detalles del Ride</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/tables.css">
    <link rel="stylesheet" href="../css/components/cards.css">
    <link rel="stylesheet" href="../css/pages/rideDetails.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header.php', ['activePage' => 'details']) ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header form-header">
                    <h2 class="section-title">Detalles de la reservacion</h2>
                    <div id="form-message" class="message"></div>
                </div>
                <div class="section-content">
                    <div class="rideDetails-container">
                        <div class="driver-info">
                            <div class="driver-photo">
                                <img src="#" id="driver-photo">
                            </div>
                            <h3>Driver</h3>
                            <p class="driver-name" id="driver-name">Nombre Completo Conductor</p>
                        </div>
                        <div class="ride-info">
                            <h2 class="ride-title" id="ride-title">Nombre del Ride</h2>
                            <h3>Información general del viaje</h3>
                            <table class="data-table ride-general-table">
                                <tbody id="ride-tbody">
                                </tbody>
                            </table>
                            <div class="vehicle-info">
                                <h3>Información del vehículo</h3>
                                <table class="data-table vehicle-info-table">
                                    <tbody id="vehicle-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="action-buttons-container">
                        <a href="javascript:window.history.back()" class="btn btn-secondary back-btn">Regresar</a>
                        <?php
                        if (!$isReservationMode) {
                            echo '<button type="submit" id="reservation-btn" class="btn btn-primary reserve-btn">Reservar asiento</button>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <form id="id-form" method="post" action="#" hidden>
                <input type="hidden" id="rideId" name="rideId" value="<?php echo $rideId ?>">
            </form>
        </main>
    </div>
    <script src="../js/mostrarMensaje.js"></script>
    <script src="../js/reservation/reservation.js"></script>
</body>

</html>