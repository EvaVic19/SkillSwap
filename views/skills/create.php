<?php require_once __DIR__ . '/../shared/header.php'; ?> 

<div class="container mt-5">
    <h2>Añadir Nueva Habilidad</h2>

    <form method="POST" action="index.php?controller=skill&action=store">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la habilidad</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Nivel</label>
            <select class="form-control" id="level" name="level" required>
                <option value="">Selecciona un nivel</option>
                <option value="Básico">Básico</option>
                <option value="Intermedio">Intermedio</option>
                <option value="Avanzado">Avanzado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipo</label>
            <select class="form-control" id="type" name="type" required>
                <option value="">Selecciona un tipo</option>
                <option value="teach">Puede enseñar</option>
                <option value="learn">Quiere aprender</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar habilidad</button>
    </form>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?> 
