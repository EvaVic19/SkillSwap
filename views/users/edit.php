<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <h2>Editar Perfil</h2>
    <form method="POST" action="index.php?controller=user&action=update" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="skill" class="form-label">Habilidad principal</label>
            <input type="text" class="form-control" id="skill" name="skill" value="<?= htmlspecialchars($user['skill'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="about" class="form-label">Sobre mí</label>
            <textarea class="form-control" id="about" name="about" rows="4" placeholder="Cuéntanos sobre ti..."><?= htmlspecialchars($user['about'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto de perfil</label>
            <input type="file" class="form-control" id="photo" name="photo">
            <?php
                $foto = !empty($user['photo']) ? 'img/' . $user['photo'] : 'img/UserP.jpg';
            ?>
            <div class="mt-2">
                <img src="<?= htmlspecialchars($foto) ?>" alt="Foto actual" style="max-width: 120px; border-radius: 8px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>


