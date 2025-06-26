<?php require_once __DIR__ . '/../shared/header.php'; ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Iniciar sesión</h2>

<?php if (!empty($_SESSION['user_id'])): ?>
    <div class="alert alert-info text-center">
        Ya has iniciado sesión como <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>.
        <br>
        <a href="index.php?controller=home&action=index" class="btn btn-sm btn-outline-primary mt-2">Ir al inicio</a>
    </div>
<?php else: ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=auth&action=login" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" name="email" class="form-control" required placeholder="Tu correo">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" name="password" class="form-control" required placeholder="Tu contraseña">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </div>
    </form>
<?php endif; ?>

    <div class="mt-3 text-center">
        <a href="index.php?controller=auth&action=forgotPassword" class="link-secondary">¿Olvidaste tu contraseña?</a>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>

