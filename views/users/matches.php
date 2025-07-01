<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Matches - SkillSwap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">
        <h2 class="mb-4">Mis Matches</h2>

        <?php if (!empty($matches)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle bg-white">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Habilidad</th>
                            <th>Instructor</th>
                            <th>Aprendiz</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach ($matches as $match): ?>
                            <tr>
                                <td><?= $match['id'] ?></td>
                                <td><?= $match['skill_name'] ?></td>
                                <td>
                                    <?= $match['instructor_id'] == $_SESSION['user_id'] ? '👤 Tú' : $match['instructor_name'] ?>
                                </td>
                                <td>
                                    <?= $match['matched_user_id'] == $_SESSION['user_id'] ? '👤 Tú' : $match['matched_user_name'] ?>
                                </td>
                                <td><?= ucfirst($match['status']) ?></td>
                                <td><?= $match['created_at'] ?></td>
                                <td>
                                    <!-- Ver siempre que el usuario esté involucrado -->
                                    <?php if ($_SESSION['user_id'] == $match['instructor_id'] || $_SESSION['user_id'] == $match['matched_user_id']): ?>
                                        <a href="index.php?controller=match&action=show&id=<?= $match['id'] ?>" class="btn btn-sm btn-info">Ver</a>
                                    <?php endif; ?>

                                    <!-- Editar solo si es admin -->
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <a href="index.php?controller=match&action=edit&id=<?= $match['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                No se encontraron matches registrados para tu cuenta.
            </div>
        <?php endif; ?>
        <div class="text-start mt-3">
            <a href="index.php?controller=match&action=create" class="btn btn-outline-success">
                Crear nuevo match
            </a>
        </div>
        <div class="text-end mt-3">
            <a href="index.php?controller=home&action=index" class="btn btn-outline-secondary">← Volver al inicio</a>
        </div>
    </div>

</body>

</html>