<?php 
// Include the shared header for the contact requests page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5">
    <h2 class="mb-4">Mis Solicitudes de Contacto</h2>

    <div class="row">
        <!-- Sent requests section -->
        <div class="col-md-6">
            <h4>Solicitudes enviadas</h4>
            <?php if (!empty($enviadas)): ?>
                <ul class="list-group">
                    <?php foreach ($enviadas as $solicitud): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <!-- Display the receiver's name and the request status -->
                            A: <?= htmlspecialchars($solicitud['receptor_name']) ?>
                            <span class="badge bg-secondary"><?= ucfirst($solicitud['status']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <!-- Info alert if no sent requests exist -->
                <div class="alert alert-info mt-3">No has enviado solicitudes aún.</div>
            <?php endif; ?>
        </div>

        <!-- Received requests section -->
        <div class="col-md-6">
            <h4>Solicitudes recibidas</h4>
            <?php if (!empty($recibidas)): ?>
                <ul class="list-group">
                    <?php foreach ($recibidas as $solicitud): ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Display the sender's name and the request status -->
                                <span>De: <?= htmlspecialchars($solicitud['emisor_name']) ?></span>
                                <span class="badge bg-secondary"><?= ucfirst($solicitud['status']) ?></span>
                            </div>

                            <?php if ($solicitud['status'] === 'pendiente'): ?>
                                <!-- Show accept and reject buttons for pending requests -->
                                <div class="mt-2 d-flex gap-2">
                                    <a href="index.php?controller=contact&action=aceptar&id=<?= $solicitud['id'] ?>" class="btn btn-sm btn-outline-success">
                                         Aceptar
                                    </a>
                                    <a href="index.php?controller=contact&action=rechazar&id=<?= $solicitud['id'] ?>" class="btn btn-sm btn-outline-danger">
                                         Rechazar
                                    </a>
                                </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <!-- Info alert if no received requests exist -->
                <div class="alert alert-info mt-3">No has recibido solicitudes aún.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
// Include the shared footer for the contact requests page
require_once __DIR__ . '/../shared/footer.php'; 
?>


