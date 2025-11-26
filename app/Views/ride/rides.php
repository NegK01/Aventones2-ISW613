<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Rides</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/components/header.css">
    <link rel="stylesheet" href="css/components/buttons.css">
    <link rel="stylesheet" href="css/components/forms.css">
    <link rel="stylesheet" href="css/components/tables.css">
    <link rel="stylesheet" href="css/components/cards.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header', ['activePage' => 'rides']) ?>

        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Gestion de Rides</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-column">
                            <input type="text" class="form-input" name="search" placeholder="Buscar rides...">
                        </div>
                        <div class="form-column text-right">
                            <a href="rideForm" class="btn btn-primary btn-none-decoration" data-rides-action="create">Crear Nuevo Ride</a>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nombre del Ride</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Fecha/Hora</th>
                                    <th>Costo</th>
                                    <th>Asientos</th>
                                    <th>Vehiculo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="rides-tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="ride-form" method="post" action="rideForm" hidden>
                <input type="hidden" name="rideId">
            </form>
        </main>
    </div>
    <script src="../js/rides/rides.js"></script>
</body>

</html>