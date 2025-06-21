<?php require_once __DIR__ . '/../shared/header.php'; ?>
<div class="container mt-5">
    <h2>Editar usuario</h2>
    <form action="index.php?controller=user&action=update" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <input name="name" class="form-control mb-2" value="<?= $user['name'] ?>" required>
        <input name="email" class="form-control mb-2" value="<?= $user['email'] ?>" required>
        <select name="role" class="form-control mb-2">
            <option value="standard" <?= $user['role'] == 'standard' ? 'selected' : '' ?>>Estándar</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
            <option value="mentor" <?= $user['role'] == 'mentor' ? 'selected' : '' ?>>Mentor</option>
        </select>
        <button class="btn btn-primary">Actualizar</button>
    </form>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
