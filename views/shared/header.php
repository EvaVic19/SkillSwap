<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- Logo + texto -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="img/Lg.Skillswap.png" alt="Logo" class="me-2" width="80" height="80">
            <span class="fw-bold fs-4 text-white">SkillSwap</span>
        </a>

        <!-- Botón responsive -->
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces del navbar -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <!-- Saludo con nombre -->
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item">
                            <span class="nav-link text-white">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        </li>
                    <?php endif; ?>

                    <!-- Enlaces comunes a todos los usuarios -->
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=user&action=show&id=<?= $_SESSION['user_id'] ?>">Mi perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=skill&action=index">Mis habilidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=match&action=misMatches">Mis Matches</a>
                    </li>

                    <!-- Solo para administradores -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white link-warning" href="index.php?controller=user&action=index">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white link-warning" href="index.php?controller=match&action=index">Todos los Matches</a>
                        </li>
                    <?php endif; ?>

                    <!-- Cerrar sesión -->
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=auth&action=logout">Cerrar sesión</a>
                    </li>

                <?php else: ?>
                    <!-- Usuarios no autenticados -->
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=user&action=create">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=auth&action=login">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>



