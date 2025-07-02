<?php 
// Include the shared header for the registration page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2 class="mb-4">Registro de nuevo usuario</h2>

    <?php if (!empty($error)): ?>
        <!-- Show an error alert if there is a registration error -->
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Registration form: submits name, email, and password via POST -->
    <form method="POST" action="index.php?controller=auth&action=register">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>

<?php 
// Include the shared footer for the registration page
require_once __DIR__ . '/../shared/footer.php'; 
?>

