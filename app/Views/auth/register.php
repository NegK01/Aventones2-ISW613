<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones - Registro</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/components/header.css">
    <link rel="stylesheet" href="css/components/buttons.css">
    <link rel="stylesheet" href="css/components/forms.css">
    <link rel="stylesheet" href="css/components/tabs.css">
    <link rel="stylesheet" href="css/sections/auth.css">
</head>

<body>
    <div class="app-container">
        <?= view('components/header', ['activePage' => 'none']); ?>

        <main class="main-content">
            <section id="register" class="section auth-section">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2>Registro</h2>
                        <p>Crea una nueva cuenta</p>
                    </div>

                    <div id="form-message" class="message"></div>

                    <div class="tabs">
                        <button id="driver-tab" class="tab active" data-tab="driver-tab">
                            Chofer
                        </button>
                        <button id="passenger-tab" class="tab" data-tab="passenger-tab">
                            Pasajero
                        </button>
                    </div>

                    <div class="tab-content active">
                        <form class="form" id="register-form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="roleId" id="roleId" value="2" />
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-firstname">Nombre</label>
                                        <input type="text" name="name" id="driver-firstname" class="form-input" placeholder="Nombre" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-lastname">Apellido</label>
                                        <input type="text" name="lastname" id="driver-lastname" class="form-input" placeholder="Apellido" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-id">Cédula</label>
                                        <input type="text" name="id" id="driver-id" class="form-input" placeholder="Número de cédula" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-birthdate">Fecha de nacimiento</label>
                                        <input type="date" name="birthdate" id="driver-birthdate" class="form-input" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-email">Correo electrónico</label>
                                        <input type="email" name="email" id="driver-email" class="form-input" placeholder="email@ejemplo.com" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-phone">Teléfono</label>
                                        <input type="tel" name="phone" id="driver-phone" class="form-input" placeholder="Teléfono" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="driver-photo">Foto</label>
                                <input type="file" name="photo" id="driver-photo" class="form-input" accept=".jpg, .jpeg, .png" />
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-password">Contraseña</label>
                                        <input type="password" name="password" id="driver-password" class="form-input" placeholder="Contraseña" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label class="form-label" for="driver-confirm-password">Confirmar contraseña</label>
                                        <input type="password" name="password-confirmation" id="driver-confirm-password" class="form-input" placeholder="Confirmar contraseña" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button id="register-btn" name="register-btn" type="submit" class="btn btn-primary" style="width: 100%">
                                    Registrarse como Chofer
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="auth-footer">
                        <p>
                            ¿Ya tienes una cuenta?
                            <a href="login" class="auth-link">Iniciar sesión</a>
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script>
        window.authConfig = {
            registerUrl: 'auth/register'
        };
    </script>
    <script src="<?= base_url('js/mostrarMensaje.js'); ?>"></script>
    <script src="<?= base_url('js/auth/registration.js'); ?>"></script>
</body>

</html>
