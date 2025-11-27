<?php
$session     = session();
$activePage  = $activePage ?? 'none';
$isLoggedIn  = $session->has('user_id');
$role        = $session->get('idRole'); // 1 = admin, 2 = chofer, 3 = pasajero
?>

<header class="nav-bar">
    <div class="nav-logo">
        <h1>Aventones</h1>
    </div>

    <?php if (!empty($role) && $role === 1) : ?>
        <!-- ADMIN -->
        <a href="<?= site_url('auth/logout'); ?>"
            class="btn btn-secondary btn-none-decoration">
            Cerrar Sesión
        </a>

    <?php elseif (!empty($role) && $role === 3) : ?>
        <!-- USUARIO ROL PASAJERO -->
        <ul class="nav-menu">
            <li><a href="<?= site_url('search'); ?>" class="<?= $activePage === 'inicio' ? 'active' : '' ?>">Inicio</a></li>
            <li><a href="<?= site_url('reservation'); ?>" class="<?= $activePage === 'reservations' ? 'active' : '' ?>">Reservas</a></li>

            <li class="nav-profile">
                <a href="<?= site_url('profile'); ?>" class="<?= $activePage === 'profile' ? 'active' : '' ?>">Perfil</a>

                <ul class="nav-submenu">
                    <a href="<?= site_url('profile'); ?>">Editar perfil</a>
                    <a href="<?= site_url('auth/logout'); ?>">Cerrar sesion</a>
                </ul>
            </li>
        </ul>

    <?php elseif ($activePage === 'none') : ?>
        <!-- NO MOSTRAR NADA -->

    <?php elseif ($isLoggedIn) : ?>
        <!-- USUARIO LOGUEADO ROL CHOFER -->
        <ul class="nav-menu">
            <li><a href="<?= site_url('search'); ?>" class="<?= $activePage === 'inicio' ? 'active' : '' ?>">Inicio</a></li>
            <li><a href="<?= site_url('rides'); ?>" class="<?= $activePage === 'rides' ? 'active' : '' ?>">Rides</a></li>
            <li><a href="<?= site_url('vehicle'); ?>" class="<?= $activePage === 'vehicles' ? 'active' : '' ?>">Vehiculos</a></li>
            <li><a href="<?= site_url('reservation'); ?>" class="<?= $activePage === 'reservations' ? 'active' : '' ?>">Reservas</a></li>

            <li class="nav-profile">
                <a href="<?= site_url('profile'); ?>" class="<?= $activePage === 'profile' ? 'active' : '' ?>">Perfil</a>

                <ul class="nav-submenu">
                    <a href="<?= site_url('profile'); ?>">Editar perfil</a>
                    <a href="<?= site_url('auth/logout'); ?>">Cerrar sesion</a>
                </ul>
            </li>
        </ul>

    <?php else : ?>
        <!-- NO LOGUEADO -->
        <a href="<?= site_url('login'); ?>"
            class="btn btn-primary btn-none-decoration">
            Iniciar Sesión
        </a>
    <?php endif; ?>
</header>