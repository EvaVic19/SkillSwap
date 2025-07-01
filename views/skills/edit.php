<?php require_once __DIR__ . '/../shared/header.php'; ?> 

<div class="container mt-5">
    <h2>Editar Habilidad</h2>
    <form method="POST" action="index.php?controller=skill&action=update">
        <input type="hidden" name="id" value="<?= $skill['id'] ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($skill['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($skill['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Nivel</label>
            <select class="form-select" id="level" name="level" required>
                <option value="Básico" <?= $skill['level'] === 'Básico' ? 'selected' : '' ?>>Básico</option>
                <option value="Intermedio" <?= $skill['level'] === 'Intermedio' ? 'selected' : '' ?>>Intermedio</option>
                <option value="Avanzado" <?= $skill['level'] === 'Avanzado' ? 'selected' : '' ?>>Avanzado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipo</label>
            <select class="form-select" id="type" name="type" required>
                <option value="teach" <?= $skill['type'] === 'teach' ? 'selected' : '' ?>>Puede enseñar</option>
                <option value="learn" <?= $skill['type'] === 'learn' ? 'selected' : '' ?>>Quiere aprender</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="category" name="category" value="<?= htmlspecialchars($skill['category']) ?>">
        </div>

        <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>
    </form>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?> 

