<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Mis Habilidades</h2>
        <a href="index.php?controller=skill&action=create" class="btn btn-outline-success">
            Añadir habilidad
        </a>
    </div>

    <?php if (!empty($skills)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Nivel</th>
                        <th>Tipo</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills as $skill): ?>
                        <tr class="text-center">
                            <td><?= htmlspecialchars($skill['name']) ?></td>
                            <td class="text-start"><?= htmlspecialchars($skill['description']) ?></td>
                            <td><?= htmlspecialchars($skill['level']) ?></td>
                            <td>
                                <span class="text-<?= $skill['type'] === 'teach' ? 'primary' : 'info' ?> fw-semibold">
                                    <?= $skill['type'] === 'teach' ? 'Puede enseñar' : 'Quiere aprender' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($skill['category']) ?></td>
                            <td>
                                <a href="index.php?controller=skill&action=edit&id=<?= $skill['id'] ?>" class="btn btn-sm btn-outline-warning me-1">
                                    Editar
                                </a>
                                <a href="index.php?controller=skill&action=delete&id=<?= $skill['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Estás seguro de eliminar esta habilidad?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Aún no has añadido habilidades. Haz clic en <strong>“Añadir habilidad”</strong> para comenzar.
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
