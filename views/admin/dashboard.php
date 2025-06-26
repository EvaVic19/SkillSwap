<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <h2>Panel de Administración</h2>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>. Aquí puedes gestionar el sistema.</p>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
