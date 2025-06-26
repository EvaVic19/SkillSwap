<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 1000px;">
        <div class="row g-0">
            <!-- FOTO DE PERFIL -->
            <div class="col-md-4 bg-light text-center d-flex align-items-center justify-content-center p-4">
                <?php
                $foto = !empty($usuario['photo']) ? 'img/' . $usuario['photo'] : 'img/UserP.jpg';
                ?>
                <img src="<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" class="img-fluid rounded-circle border" style="max-width: 200px; max-height: 200px; object-fit: cover;">
            </div>

            <!-- INFORMACIÓN DEL USUARIO -->
            <div class="col-md-8 p-4">
                <h3 class="fw-bold"><?= htmlspecialchars($usuario['name']) ?></h3>
                
                <p class="mb-3">
                    <strong> Sobre mí:</strong><br>
                    <?= !empty($usuario['about']) ? nl2br(htmlspecialchars($usuario['about'])) : '<span class="text-muted">Este usuario aún no ha agregado una descripción.</span>' ?>
                </p>

                <!-- HABILIDADES ENSEÑAR -->
                <h5 class="text-warning"> Habilidades que puede enseñar:</h5>
                <?php
                $enseñar = array_filter($skills, fn($s) => $s['type'] === 'teach');
                ?>
                <?php if (!empty($enseñar)): ?>
                    <ul class="mb-3">
                        <?php foreach ($enseñar as $skill): ?>
                            <li>
                                <strong><?= htmlspecialchars($skill['name']) ?></strong>
                                (<?= htmlspecialchars($skill['level']) ?> - <?= htmlspecialchars($skill['category']) ?>)
                                <br><small><?= htmlspecialchars($skill['description']) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-3">No ha agregado habilidades para enseñar.</p>
                <?php endif; ?>

                <!-- HABILIDADES APRENDER -->
                <h5 class="text-info"> Habilidades que quiere aprender:</h5>
                <?php
                $aprender = array_filter($skills, fn($s) => $s['type'] === 'learn');
                ?>
                <?php if (!empty($aprender)): ?>
                    <ul class="mb-3">
                        <?php foreach ($aprender as $skill): ?>
                            <li>
                                <strong><?= htmlspecialchars($skill['name']) ?></strong>
                                (<?= htmlspecialchars($skill['level']) ?> - <?= htmlspecialchars($skill['category']) ?>)
                                <br><small><?= htmlspecialchars($skill['description']) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-3">No ha agregado habilidades que quiere aprender.</p>
                <?php endif; ?>

                <!-- BOTONES -->
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="#" class="btn btn-success"> Contactar</a>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $usuario['id']): ?>
                        <a href="index.php?controller=user&action=edit&id=<?= $usuario['id'] ?>" class="btn btn-warning">✏️ Editar perfil</a>
                        <a href="index.php?controller=skill&action=index" class="btn btn-outline-info"> Gestionar habilidades</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>





