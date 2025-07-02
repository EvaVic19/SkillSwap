<?php 
// Include the shared header for the create match page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2>Crear nuevo Match</h2>

    <!-- Form to create a new match: selects skill, user, and status -->
    <form action="index.php?controller=Match&action=store" method="POST" class="mt-4">

        <div class="mb-3">
            <!-- Dropdown to select the offered skill -->
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
            <!-- Dropdown to select the user who wants the skill -->
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
            <!-- Dropdown to select the match status -->
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="pendiente" selected>Pendiente</option>
                <option value="aceptado">Aceptado</option>
                <option value="rechazado">Rechazado</option>
            </select>
        </div>

        <!-- Submit button to save the match and a cancel button -->
        <button type="submit" class="btn btn-outline-primary">Guardar</button>
        <a href="index.php?controller=Match&action=index" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>

<?php 
// Include the shared footer for the create match page
require_once __DIR__ . '/../shared/footer.php'; 
?>
