<?php 
// Include the shared header for the matches list page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2 class="mb-4">Listado de Matches</h2>

    <?php if (!empty($matches)): ?>
        <!-- Table displaying all matches with their details -->
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
                            <!-- Action buttons: edit, delete, and view match details -->
                            <a href="index.php?controller=Match&action=edit&id=<?= $match['id'] ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                            <a href="index.php?controller=Match&action=delete&id=<?= $match['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar este match?')">Eliminar</a>
                            <a href="index.php?controller=Match&action=show&id=<?= $match['id'] ?>" class="btn btn-outline-info btn-sm">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Alert if there are no match records -->
        <div class="alert alert-warning">No hay registros de matches.</div>
    <?php endif; ?>
</div>

<?php 
// Include the shared footer for the matches list page
require_once __DIR__ . '/../shared/footer.php'; 
?>

