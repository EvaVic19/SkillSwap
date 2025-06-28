<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Listado de Matches</h2>

    <?php if (!empty($matches)): ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Habilidad</th>
                    <th>ID Usuario Coincidente</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matches as $match): ?>
                    <tr>
                        <td><?= $match['id'] ?></td>
                        <td><?= $match['skill_id'] ?></td>
                        <td><?= $match['matched_user_id'] ?></td>
                        <td><?= $match['status'] ?></td>
                        <td><?= $match['created_at'] ?></td>
                        <td>
                            <a href="index.php?controller=Match&action=edit&id=<?= $match['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="index.php?controller=Match&action=delete&id=<?= $match['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este match?')">Eliminar</a>
                            <a href="index.php?controller=Match&action=show&id=<?= $match['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No hay registros de matches.</div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
