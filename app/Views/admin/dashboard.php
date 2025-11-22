<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Administracion</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/components/header.css">
    <link rel="stylesheet" href="css/components/buttons.css">
    <link rel="stylesheet" href="css/components/forms.css">
    <link rel="stylesheet" href="css/components/tables.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header', ['activePage' => 'none']) ?>

        <main class="main-content">
            <section class="section">
                <div class="section-header">
                    <h2 class="section-title">Panel de administracion</h2>
                </div>

                <div class="form-row" style="align-items: flex-end;">
                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label" for="user-status-filter">Mostrar usuarios</label>
                            <select id="user-status-filter" class="form-select">
                                <option value=0>Todos</option>
                                <option value=4>Activos</option>
                                <option value=5>Inactivos</option>
                                <option value=2>Pendientes</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group text-right">
                            <a href="adminForm" class="btn btn-primary btn-none-decoration" data-rides-action="create">Crear Administrador</a>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="col-name">Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Fecha de registro</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="users-tbody">
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <form id="user-form" method="post" action="#" hidden>
        <input type="hidden" name="userId">
        <input type="hidden" name="statusId">
    </form>

    <script src="../js/admin/admin.js"></script>
</body>

</html>