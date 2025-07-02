<?php 
// Start session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SkillSwap</title>
    <!-- Import Bootstrap CSS for responsive design and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigation bar for the application -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- Logo and brand text -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="img/Lg.Skillswap.png" alt="Logo" class="me-2" width="80" height="80">
            <span class="fw-bold fs-4 text-white">SkillSwap</span>
        </a>

        <!-- Responsive navbar toggle button -->
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <!-- Greeting with the user's name -->
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item">
                            <span class="nav-link text-white">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        </li>
                    <?php endif; ?>

                    <!-- Links available to all authenticated users -->
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=user&action=show&id=<?= $_SESSION['user_id'] ?>">Mi perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=skill&action=index">Mis habilidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=match&action=misMatches">Mis Matches</a>
                    </li>

                    <!-- Admin-only links -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white link-warning" href="index.php?controller=user&action=index">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white link-warning" href="index.php?controller=match&action=index">Todos los Matches</a>
                        </li>
                    <?php endif; ?>

                    <!-- Logout link -->
                    <li class="nav-item">
                        <a class="nav-link text-white link-warning" href="index.php?controller=auth&action=logout">Cerrar sesión</a>
                    </li>

                <?php else: ?>
                    <!-- Links for unauthenticated users -->
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

<!-- SweetAlert2 custom alerts script -->
<script src="public/js/sweetalert.js"></script>

<!-- Show success alert if the request was sent successfully -->
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<script>
  mostrarAlertaExito("¡Solicitud enviada correctamente!");
</script>
<?php endif; ?>

<!-- Show error alerts based on different error types -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'self'): ?>
<script>
  mostrarAlertaError("No puedes enviarte una solicitud a ti misma.");
</script>
<?php elseif (isset($_GET['error']) && $_GET['error'] == 'db'): ?>
<script>
  mostrarAlertaError("Hubo un error al enviar la solicitud.");
</script>
<?php elseif (isset($_GET['error'])): ?>
<script>
  mostrarAlertaError("Acción no autorizada.");
</script>
<?php endif; ?>

<!-- Show info alert if a request already exists -->
<?php if (isset($_GET['info']) && $_GET['info'] == 'exists'): ?>
<script>
  mostrarAlertaError("Ya enviaste una solicitud a esta persona.");
</script>
<?php endif; ?>

