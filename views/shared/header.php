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
    <style>
        .navbar-nav .nav-link {
            color: white !important;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107 !important; /* Bootstrap warning */
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .navbar-brand span {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark shadow-sm">
    <div class="container">
        <!-- LOGO y NOMBRE -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="img/Lg.Skillswap.png" alt="Logo" class="me-2">
            <span>SkillSwap</span>
        </a>

        <!-- Botón responsive -->
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=user&action=show&id=<?= $_SESSION['user_id'] ?>">Mi perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=skill&action=index">Mis habilidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="index.php?controller=auth&action=logout">Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=user&action=create">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=login">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
