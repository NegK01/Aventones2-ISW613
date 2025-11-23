<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Perfil</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/components/header.css">
    <link rel="stylesheet" href="css/components/buttons.css">
    <link rel="stylesheet" href="css/components/forms.css">
    <link rel="stylesheet" href="css/sections/profile.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header.php', ['activePage' => 'profile'])?>
        <main class="main-content">
            <div class="section">
                <div class="section-header form-header">
                    <h2 class="section-title">Mi Perfil</h2>
                    <div id="form-message" class="message"></div>
                </div>
                <div class="profile-header" id="profile-header">
                    <div class="profile-image">
                        <img id="image">
                    </div>
                    <div>
                        <h3 id="title-name"></h3>
                        <p id="profile-role"></p>
                    </div>
                </div>
                <div class="section-content">
                    <form class="form" id="profile-form">
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-firstname">Nombre</label>
                                    <input type="text" id="profile-firstname" name="profile-firstname" class="form-input">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-lastname">Apellido</label>
                                    <input type="text" id="profile-lastname" name="profile-lastname" class="form-input">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-id">Cédula</label>
                                    <input type="text" id="profile-id" name="profile-id" class="form-input">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-birthdate">Fecha de nacimiento</label>
                                    <input type="date" id="profile-birthdate" name="profile-birthdate" class="form-input">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-email">Correo electrónico</label>
                                    <input type="email" id="profile-email" name="profile-email" class="form-input">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-phone">Teléfono</label>
                                    <input type="tel" id="profile-phone" name="profile-phone" class="form-input">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="profile-photo">Foto</label>
                            <input type="file" id="profile-photo" class="form-input" name="photo">
                        </div>
                        <hr style="margin: var(--spacing-lg) 0; border-color: var(--color-border);">
                        <h3 style="margin-bottom: var(--spacing-md);">Cambiar contraseña</h3>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-current-password">Contraseña actual</label>
                                    <input type="password" id="profile-current-password" class="form-input" name="profile-current-password" placeholder="Contraseña actual">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-new-password">Nueva contraseña</label>
                                    <input type="password" id="profile-new-password" class="form-input" name="profile-new-password" placeholder="Nueva contraseña">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-confirm-password">Confirmar nueva contraseña</label>
                                    <input type="password" id="profile-confirm-password" class="form-input" name="profile-confirm-password" placeholder="Confirmar nueva contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/mostrarMensaje.js"></script>
    <script src="../js/auth/profile.js"></script>

</body>

</html>