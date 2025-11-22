<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones - Iniciar sesión</title>
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
            <section id="login" class="section auth-section">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2>Iniciar sesión</h2>
                        <p>Ingresa tus credenciales para acceder</p>
                    </div>

                    <div id="form-message" class="message"></div>

                    <form id="login-form" class="form">
                        <div class="form-group">
                            <label class="form-label" for="login-email">Email</label>
                            <input name="email" type="text" id="login-email" class="form-input" placeholder="email@ejemplo.com" autocomplete="email" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="login-password">Contraseña</label>
                            <input name="password" type="password" id="login-password" class="form-input" placeholder="Contraseña" />
                        </div>
                        <div class="form-group">
                            <button type="submit" id="form-submit" class="btn btn-primary" style="width: 100%">
                                Iniciar sesión
                            </button>
                        </div>
                    </form>
                    <div class="auth-footer">
                        <p>
                            ¿No tienes una cuenta?
                            <a href="<?= site_url('register'); ?>" class="auth-link">Regístrate</a>
                        </p>
                        <!-- <p>
                            ¿No tienes una cuenta?
                            <a href="/register" class="auth-link">Regístrate</a>
                        </p> -->
                        <div class="auth-divider">
                            <span>O continuar sin registro</span>
                        </div>
                        <a href="<?= site_url('search'); ?>" class="btn btn-secondary auth-guest-btn">
                            Entrar como invitado
                        </a>
                        <p class="auth-guest-hint">
                            Explora Aventones antes de crear tu cuenta
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="<?= base_url('js/mostrarMensaje.js'); ?>"></script>
    <script src="<?= base_url('js/auth/login.js'); ?>"></script>
</body>

</html>
