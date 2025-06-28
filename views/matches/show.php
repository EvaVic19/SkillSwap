<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <h2>Detalle del Match</h2>

    <?php if ($match): ?>
        <ul class="list-group mt-4">
            <li class="list-group-item"><strong>ID:</strong> <?= $match['id'] ?></li>
            <li class="list-group-item"><strong>Habilidad ID:</strong> <?= $match['skill_id'] ?></li>
            <li class="list-group-item"><strong>Usuario Coincidente ID:</strong> <?= $match['matched_user_id'] ?></li>
            <li class="list-group-item"><strong>Estado:</strong> <?= ucfirst($match['status']) ?></li>
            <li class="list-group-item"><strong>Fecha de creación:</strong> <?= $match['created_at'] ?></li>
        </ul>
    <?php else: ?>
        <div class="alert alert-danger mt-4">No se encontró el match solicitado.</div>
    <?php endif; ?>

    <a href="index.php?controller=Match&action=index" class="btn btn-secondary mt-4">← Volver al listado</a>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
