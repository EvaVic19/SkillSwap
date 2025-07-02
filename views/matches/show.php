<?php 
// Include the shared header for the match detail page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2>Detalle del Match</h2>

    <?php if ($match): ?>
        <!-- Display match details: skill, instructor, learner, status, and creation date -->
        <ul>
            <li><strong>Habilidad:</strong> <?= htmlspecialchars($match['skill_name']) ?></li>
            <li><strong>Instructor:</strong> <?= htmlspecialchars($match['instructor_name']) ?></li>
            <li><strong>Aprendiz:</strong> <?= htmlspecialchars($match['matched_user_name']) ?></li>
            <li><strong>Estado:</strong> <?= ucfirst($match['status']) ?></li>
            <li><strong>Fecha de creación:</strong> <?= $match['created_at'] ?></li>
        </ul>
    <?php else: ?>
        <!-- Alert if the requested match is not found -->
        <div class="alert alert-danger mt-4">No se encontró el match solicitado.</div>
    <?php endif; ?>

    <!-- Button to return to the matches list -->
    <a href="index.php?controller=Match&action=index" class="btn btn-outline-secondary mt-4">← Volver al listado</a>
</div>

<?php 
// Include the shared footer for the match detail page
require_once __DIR__ . '/../shared/footer.php'; 
?>


