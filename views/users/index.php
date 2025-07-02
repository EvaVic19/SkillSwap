<?php 
// Include the shared header for the registered users list page
require_once __DIR__ . '/../shared/header.php'; 
?>

<div class="container mt-5 bg-light p-4 rounded-4 shadow-sm">
    <h2 class="text-center mb-4">Usuarios registrados</h2>
    <div class="d-flex justify-content-end mb-3">
        <!-- Button to add a new user -->
        <a href="index.php?controller=user&action=create" class="btn btn-success"> Nuevo usuario</a>
    </div>

    <div class="table-responsive">
        <!-- Table displaying all registered users with their details -->
        <table class="table table-hover align-middle table-bordered border-secondary-subtle shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td class="text-capitalize"><?= $user['role'] ?></td>
                        <td>
                            <!-- Edit and delete buttons for each user -->
                            <a href="index.php?controller=user&action=edit&id=<?= $user['id'] ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                            <a href="index.php?controller=user&action=delete&id=<?= $user['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
// Include the shared footer for the registered users list page
require_once __DIR__ . '/../shared/footer.php'; 
?>


