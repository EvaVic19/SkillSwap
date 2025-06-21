<?php require_once __DIR__ . '/../shared/header.php'; ?>
<div class="container mt-5">
    <h2>Usuarios registrados</h2>
    <a href="index.php?controller=user&action=create" class="btn btn-success mb-3">Nuevo usuario</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <a href="index.php?controller=user&action=edit&id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="index.php?controller=user&action=delete&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
