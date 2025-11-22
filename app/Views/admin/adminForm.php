<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Crear Administrador</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/components/header.css">
    <link rel="stylesheet" href="css/components/buttons.css">
    <link rel="stylesheet" href="css/components/forms.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header') ?>

        <main class="main-content">
            <section class="section">
                <div class="section-header form-header">
                    <h2 class="section-title">Crear administrador</h2>
                    <div id="form-message" class="message"></div>
                </div>

                <div class="section-content">
                    <form id="admin-create-form" class="form" enctype="multipart/form-data">
                        <input type="hidden" name="roleId" id="roleId" value="1" />
                        <input type="hidden" name="statusId" id="statusId" value="4" />
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-firstname">Nombre</label>
                                    <input type="text" id="admin-firstname" name="name" class="form-input" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-lastname">Apellido</label>
                                    <input type="text" id="admin-lastname" name="lastname" class="form-input" placeholder="Apellido">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-id">Cedula</label>
                                    <input type="text" id="admin-id" name="id" class="form-input" placeholder="Numero de cedula">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-birthdate">Fecha de nacimiento</label>
                                    <input type="date" id="admin-birthdate" name="birthdate" class="form-input">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-email">Correo electronico</label>
                                    <input type="email" id="admin-email" name="email" class="form-input" placeholder="email@ejemplo.com">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-phone">Telefono</label>
                                    <input type="tel" id="admin-phone" name="phone" class="form-input" placeholder="Telefono">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="admin-photo">Foto</label>
                            <input type="file" id="admin-photo" name="photo" class="form-input" accept=".jpg, .jpeg, .png">
                        </div>

                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-password">Contrasena temporal</label>
                                    <input type="password" id="admin-password" name="password" class="form-input" placeholder="Contrasena temporal">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="admin-confirm-password">Confirmar contrasena</label>
                                    <input type="password" id="admin-confirm-password" name="password-confirmation" class="form-input" placeholder="Confirmar contrasena">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="dashboard" class="btn btn-secondary btn-none-decoration">Cancelar</a>
                            <button id="submit-admin" type="submit" class="btn btn-primary">Guardar administrador</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script src="../js/mostrarMensaje.js"></script>
    <script src="../js/admin/adminCreate.js"></script>
</body>

</html>