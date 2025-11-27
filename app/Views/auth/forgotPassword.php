<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones - Recuperar contraseña</title>
    <link rel="stylesheet" href="<?= base_url('css/base.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/layout.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/utilities.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/components/header.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/components/buttons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/components/forms.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/sections/auth.css'); ?>">
</head>

<body>
    <div class="app-container">
        <?= view('components/header', ['activePage' => 'none']); ?>

        <main class="main-content">
            <section id="forgot-password" class="section auth-section">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2>¿Olvidaste tu contraseña?</h2>
                        <p>Ingresa tu correo para obtener un enlace de recuperación</p>
                    </div>

                    <div id="form-message" class="message"></div>

                    <form id="forgot-password-form" class="form">
                        <div class="form-group">
                            <label class="form-label" for="forgot-email">Correo electrónico</label>
                            <input type="email" id="forgot-email" name="email" class="form-input" placeholder="email@ejemplo.com" autocomplete="email" required />
                        </div>
                        <div class="form-group">
                            <button id="form-submit" type="submit" class="btn btn-primary" style="width: 100%;">
                                Enviar correo
                            </button>
                        </div>
                    </form>

                    <div class="auth-footer">
                        <p>
                            ¿Recordaste tu contraseña?
                            <a href="<?= site_url('login'); ?>" class="auth-link">Volver a iniciar sesión</a>
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="<?= base_url('js/mostrarMensaje.js'); ?>"></script>
    <script src="<?= base_url('js/auth/forgotPassword.js'); ?>"></script>
</body>

</html>