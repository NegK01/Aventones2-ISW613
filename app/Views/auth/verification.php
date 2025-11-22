<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Verificacion</title>
    <link rel="stylesheet" href="<?= base_url('css/base.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/layout.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/utilities.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/components/header.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/components/buttons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/sections/auth.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/verification.css'); ?>">
</head>

<body>
    <div class="app-container">
        <header class="nav-bar">
            <div class="nav-logo">
                <h1>Aventones</h1>
            </div>
        </header>

        <main class="main-content">
            <section id="verification" class="active section auth-section">
                <div class="verification-container">
                    <div id="verification-icon" class="verification-icon"></div>
                    <h2 id="verification-message" class="verification-text">Toca el boton para verificar tu cuenta</h2>
                    <button id="verify-btn" class="btn btn-primary verification-button">Activar cuenta</button>
                </div>
            </section>
        </main>
    </div>

    <script>
        window.authConfig = {
            verifyUrl: '<?= site_url('auth/verification'); ?>',
            loginUrl: '<?= site_url('login'); ?>'
        };
    </script>
    <script src="<?= base_url('js/auth/verification.js'); ?>"></script>
</body>

</html>
