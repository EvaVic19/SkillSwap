<?php 
// Include the shared header for the available users page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Personas disponibles para intercambiar habilidades</h2>

    <!-- Search form: allows filtering users by skill -->
    <form method="GET" action="index.php" class="mb-5">
        <input type="hidden" name="controller" value="home">
        <input type="hidden" name="action" value="index">
        <div class="input-group">
            <input type="text" name="filtro" class="form-control" placeholder="Buscar una habilidad..." value="<?= htmlspecialchars($_GET['filtro'] ?? '') ?>">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>
    <?php if (isset($_GET['filtro']) && empty($usuarios)): ?>
        <!-- Alert if no users were found with the searched skill -->
        <div class="alert alert-warning mt-4" role="alert">
            No se encontraron personas con esa habilidad. ¡Intenta con otra!
        </div>
    <?php endif; ?>
    <!-- List of users available for skill exchange -->
    <div class="row g-4">
        <?php foreach ($usuarios as $usuario): ?>
            <?php
            // Determine the user's profile photo or use a default image
            $foto = !empty($usuario['photo']) ? 'img/' . $usuario['photo'] : 'img/UserP.jpg';
            ?>
            <div class="col-12">
                <div class="card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <!-- Circular profile photo -->
                        <img src="<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" class="rounded-circle me-4" style="width: 100px; height: 100px; object-fit: cover;">

                        <!-- User information: name, skill, and profile link -->
                        <div class="flex-grow-1">
                            <h5 class="mb-1"><?= htmlspecialchars($usuario['name']) ?></h5>
                            <p class="mb-1"><strong>Habilidad:</strong> <?= htmlspecialchars($usuario['skill']) ?></p>
                            <a href="index.php?controller=user&action=show&id=<?= $usuario['id'] ?>" class="btn btn-outline-primary btn-sm">Ver perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php 
// Include the shared footer for the available users page
require_once __DIR__ . '/../shared/footer.php'; 
?>
