<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <h2>Crear nuevo Match</h2>

    <form action="index.php?controller=Match&action=store" method="POST" class="mt-4">

        <div class="mb-3">
            <label for="skill_id" class="form-label">Habilidad ofrecida</label>
            <select class="form-select" name="skill_id" id="skill_id" required>
                <option value="" disabled selected>Selecciona una habilidad</option>
                <?php foreach ($skills as $skill): ?>
                    <option value="<?= $skill['id'] ?>">
                        <?= htmlspecialchars($skill['name']) ?> (Usuario ID <?= $skill['user_id'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="matched_user_id" class="form-label">Usuario que desea esta habilidad</label>
            <select class="form-select" name="matched_user_id" id="matched_user_id" required>
                <option value="" disabled selected>Selecciona un usuario</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>">
                        <?= htmlspecialchars($user['name']) ?> (<?= $user['email'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="pendiente" selected>Pendiente</option>
                <option value="aceptado">Aceptado</option>
                <option value="rechazado">Rechazado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php?controller=Match&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>

