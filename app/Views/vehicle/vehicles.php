<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Vehiculos</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
    <link rel="stylesheet" href="../css/components/tables.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header.php', ['activePage' => 'vehicles']) ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Mis Vehiculos</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-column">
                            <input type="text" class="form-input" placeholder="Buscar vehiculos...">
                        </div>
                        <div class="form-column text-right">
                            <a href="vehicleForm.php" class="btn btn-primary btn-none-decoration" vehicle-action="create">Agregar Vehiculo</a>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Anio</th>
                                    <th>Color</th>
                                    <th>Placa</th>
                                    <th>Capacidad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="vehicles-tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="vehicle-form" method="post" action="vehicleForm.php" hidden>
                <input type="hidden" name="vehicleId">
            </form>
        </main>
    </div>
    <script src="../js/vehicles/vehicles.js"></script>
</body>

</html>