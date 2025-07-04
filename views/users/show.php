<?php 
// Include the shared header for the user profile page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="row g-4 align-items-center">

            <!-- Circular profile photo -->
            <div class="col-md-3 text-center">
                <?php
                // Determine the user's profile photo or use a default image
                $foto = !empty($usuario['photo']) ? 'img/' . $usuario['photo'] : 'img/UserP.jpg';
                ?>
                <img src="<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" class="rounded-circle shadow" style="width: 140px; height: 140px; object-fit: cover;">
            </div>

            <!-- User data section -->
            <div class="col-md-9">
                <h2 class="fw-semibold mb-3"><?= htmlspecialchars($usuario['name']) ?></h2>

                <p class="mb-3 fs-5">
                    <strong>Sobre mí:</strong><br>
                    <?= !empty($usuario['about']) ? nl2br(htmlspecialchars($usuario['about'])) : '<span class="text-muted">Este usuario aún no ha agregado una descripción.</span>' ?>
                </p>

                <!-- Skills the user can teach -->
                <div class="mb-3">
                    <h5 class="text-secondary fw-bold"> Habilidades que puede enseñar</h5>
                    <?php
                    $enseñar = array_filter($skills, fn($s) => $s['type'] === 'teach');
                    ?>
                    <?php if (!empty($enseñar)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($enseñar as $skill): ?>
                                <li class="list-group-item ps-0">
                                    <strong><?= htmlspecialchars($skill['name']) ?></strong> (<?= htmlspecialchars($skill['level']) ?> - <?= htmlspecialchars($skill['category']) ?>)
                                    <br><small class="text-muted"><?= htmlspecialchars($skill['description']) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No ha agregado habilidades para enseñar.</p>
                    <?php endif; ?>
                </div>

                <!-- Skills the user wants to learn -->
                <div class="mb-4">
                    <h5 class="text-secondary fw-bold"> Habilidades que quiere aprender</h5>
                    <?php
                    $aprender = array_filter($skills, fn($s) => $s['type'] === 'learn');
                    ?>
                    <?php if (!empty($aprender)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($aprender as $skill): ?>
                                <li class="list-group-item ps-0">
                                    <strong><?= htmlspecialchars($skill['name']) ?></strong> (<?= htmlspecialchars($skill['level']) ?> - <?= htmlspecialchars($skill['category']) ?>)
                                    <br><small class="text-muted"><?= htmlspecialchars($skill['description']) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No ha agregado habilidades que quiere aprender.</p>
                    <?php endif; ?>
                </div>

                <!-- Action buttons: contact, edit profile, manage skills, view requests -->
                <div class="d-flex gap-2 align-items-center flex-wrap flex-row">

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $usuario['id']): ?>

                        <!-- Contact button: only for other users -->
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="controller" value="contact">
                            <input type="hidden" name="action" value="sendRequest">
                            <input type="hidden" name="receiver_id" value="<?= $usuario['id'] ?>">
                            <button type="submit" class="btn btn-outline-success btn-sm">Contactar</button>
                        </form>

                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $usuario['id']): ?>
                        <!-- Edit profile and manage skills buttons: only for the profile owner -->
                        <a href="index.php?controller=user&action=edit&id=<?= $usuario['id'] ?>" class="btn btn-outline-warning">Editar perfil</a>
                        <a href="index.php?controller=skill&action=index" class="btn btn-outline-info">Gestionar habilidades</a>
                    <?php endif; ?>
                    <!-- Button to view contact requests -->
                    <a href="index.php?controller=contact&action=misSolicitudes" class="btn btn-outline-info btn-sm">Ver solicitudes</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php 
// Include the shared footer for the user profile page
require_once __DIR__ . '/../shared/footer.php'; 
?>
