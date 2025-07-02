<?php 
// Include the shared header for the admin panel page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2>Panel de Administración</h2>
    <!-- Welcome message displaying the logged-in user's name -->
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>. Aquí puedes gestionar el sistema.</p>
</div>

<?php 
// Include the shared footer for the admin panel page
require_once __DIR__ . '/../shared/footer.php'; 
?>

