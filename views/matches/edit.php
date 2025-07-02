<?php 
// Include the shared header for the edit match page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2>Editar Match</h2>

    <?php if ($match): ?>
        <!-- Edit match form: allows updating the status of the match -->
        <form action="index.php?controller=Match&action=update" method="POST" class="mt-4">
            <!-- Hidden field with the match ID -->
            <input type="hidden" name="id" value="<?= $match['id'] ?>">

            <div class="mb-3">
                <!-- Display the skill ID (disabled, not editable) -->
                <label class="form-label">ID de Habilidad</label>
                <input type="number" class="form-control" value="<?= $match['skill_id'] ?>" disabled>
            </div>

            <div class="mb-3">
                <!-- Display the matched user ID (disabled, not editable) -->
                <label class="form-label">ID del Usuario Coincidente</label>
                <input type="number" class="form-control" value="<?= $match['matched_user_id'] ?>" disabled>
            </div>

            <div class="mb-3">
                <!-- Dropdown to update the match status -->
                <label for="status" class="form-label">Estado</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="pendiente" <?= $match['status'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="aceptado" <?= $match['status'] === 'aceptado' ? 'selected' : '' ?>>Aceptado</option>
                    <option value="rechazado" <?= $match['status'] === 'rechazado' ? 'selected' : '' ?>>Rechazado</option>
                </select>
            </div>

            <!-- Submit button to save changes and a cancel button -->
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="index.php?controller=Match&action=index" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php else: ?>
        <!-- Alert if the match is not found -->
        <div class="alert alert-danger mt-4">Match no encontrado.</div>
    <?php endif; ?>
</div>

<?php 
// Include the shared footer for the edit match page
require_once __DIR__ . '/../shared/footer.php'; 
?>

