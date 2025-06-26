<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Personas disponibles para intercambiar habilidades</h2>

    <!-- Barra de búsqueda -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar una habilidad..." value="<?= htmlspecialchars($filtro ?? '') ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Lista de usuarios -->
    <div class="row">
        <?php foreach ($usuarios as $usuario): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($usuario['photo']) ?>" class="card-img-top" alt="Foto de perfil" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($usuario['name']) ?></h5>
                        <p class="card-text"><strong>Habilidad:</strong> <?= htmlspecialchars($usuario['skill']) ?></p>

                        <a href="index.php?controller=user&action=show&id=<?= $usuario['id'] ?>" class="btn btn-outline-primary">Ver perfil</a>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>

