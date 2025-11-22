<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones - Inicio</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/components/header.css">
    <link rel="stylesheet" href="css/components/buttons.css ">
    <link rel="stylesheet" href="css/components/forms.css">
    <link rel="stylesheet" href="css/components/tables.css">
    <link rel="stylesheet" href="css/components/cards.css">
    <link rel="stylesheet" href="css/sections/search.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header', ['activePage' => 'inicio']) ?>

        <main class="main-content">
            <div class="section">
                <div class="section-header form-header">
                    <h2 class="section-title">Buscar Rides</h2>
                    <div id="form-message" class="message"></div>
                </div>
                <div class="section-content">
                    <form class="search-form" id="search-form">
                        <div class="form-row">
                            <div class="form-column">
                                <label
                                    class="form-label"
                                    for="search-origin">Origen</label>
                                <input
                                    type="text"
                                    id="search-origin"
                                    name="search-origin"
                                    class="form-input"
                                    placeholder="Origen" />
                            </div>
                            <div class="form-column">
                                <label
                                    class="form-label"
                                    for="search-destination">Destino</label>
                                <input
                                    type="text"
                                    id="search-destination"
                                    name="search-destination"
                                    class="form-input"
                                    placeholder="Destino" />
                            </div>
                            <div class="form-column text-right">
                                <button
                                    type="submit"
                                    class="btn btn-primary">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <label class="form-label" for="sort-criteria">Ordenar por</label>
                        <select id="sort-criteria" class="form-select">
                            <option value="date-asc" selected>
                                Fecha: mas cercana → mas lejana
                            </option>
                            <option value="date-desc">
                                Fecha: mas lejana → mas cercana
                            </option>
                            <option value="origin-asc">
                                Origen: A → Z
                            </option>
                            <option value="origin-desc">
                                Origen: Z → A
                            </option>
                            <option value="destination-asc">
                                Destino: A → Z
                            </option>
                            <option value="destination-desc">
                                Destino: Z → A
                            </option>
                        </select>
                    </div>
                    <div class="table-container">
                        <table class="data-table ride-table">
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
            
            <div class="section">
                <div class="section-header">
                    <h3 class="section-title">Rides Populares</h3>
                </div>
                <div class="card-list">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Viaje a la Universidad</h4>
                            <span class="badge green-badge">Disponible</span>
                        </div>
                        <div class="card-content">
                            <p><strong>Origen:</strong> Cumbayá</p>
                            <p><strong>Destino:</strong> USFQ</p>
                            <p><strong>Fecha/Hora:</strong> 18/05/2025 08:00</p>
                            <p><strong>Costo:</strong> $2.50</p>
                            <p><strong>Asientos:</strong> 3</p>
                            <p><strong>Vehículo:</strong> Toyota Corolla (2020)</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-secondary">Reservar</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Viaje de regreso a casa</h4>
                            <span class="badge green-badge">Disponible</span>
                        </div>
                        <div class="card-content">
                            <p><strong>Origen:</strong> USFQ</p>
                            <p><strong>Destino:</strong> Cumbayá</p>
                            <p><strong>Fecha/Hora:</strong> 18/05/2025 17:00</p>
                            <p><strong>Costo:</strong> $2.50</p>
                            <p><strong>Asientos:</strong> 4</p>
                            <p><strong>Vehículo:</strong> Toyota Corolla (2020)</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-secondary">Reservar</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Viaje al aeropuerto</h4>
                            <span class="badge yellow-badge">Pocos asientos</span>
                        </div>
                        <div class="card-content">
                            <p><strong>Origen:</strong> Centro Norte</p>
                            <p><strong>Destino:</strong> Aeropuerto Mariscal Sucre</p>
                            <p><strong>Fecha/Hora:</strong> 20/05/2025 10:00</p>
                            <p><strong>Costo:</strong> $5.00</p>
                            <p><strong>Asientos:</strong> 2</p>
                            <p><strong>Vehículo:</strong> Honda Civic (2022)</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-secondary">Reservar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="section-header">
                    <h3 class="section-title">Resumen</h3>
                </div>
                <div class="card-list">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Mis Rides</h4>
                        </div>
                        <div class="card-content">
                            <p>Tienes 3 rides activos</p>
                        </div>
                        <div class="card-footer">
                            <a href="rides" class="btn btn-secondary btn-none-decoration">Ver todos</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Mis Vehículos</h4>
                        </div>
                        <div class="card-content">
                            <p>Tienes 2 vehículos registrados</p>
                        </div>
                        <div class="card-footer">
                            <a
                                href="vehicles "
                                class="btn btn-secondary btn-none-decoration">Ver todos</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Mis Reservas</h4>
                        </div>
                        <div class="card-content">
                            <p>Tienes 1 reserva pendiente</p>
                        </div>
                        <div class="card-footer">
                            <a
                                href="reservations"
                                class="btn btn-secondary btn-none-decoration">Ver todas</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/mostrarMensaje.js"></script>
    <script src="js/search/search.js"></script>
    <script src="js/reserve/reserve.js"></script>
</body>

</html>
