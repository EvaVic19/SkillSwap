<?php require_once __DIR__ . '/../shared/header.php'; ?>
<div class="container mt-5">
    <h2>Registrar nuevo usuario</h2>
    <form action="index.php?controller=user&action=store" method="POST">
        <input name="name" class="form-control mb-2" placeholder="Nombre" required>
        <input name="email" class="form-control mb-2" type="email" placeholder="Email" required>
        <input name="password" class="form-control mb-2" type="password" placeholder="Contraseña" required>
        <select name="role" class="form-control mb-2">
            <option value="standard">Estándar</option>
            <option value="admin">Administrador</option>
            <option value="mentor">Mentor</option>
        </select>
        <button class="btn btn-outline-success">Guardar</button>
    </form>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
