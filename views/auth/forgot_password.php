<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <!-- Import Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Recuperar contraseña</h2>
    <!-- Password recovery form: sends a POST request with the user's email -->
    <form method="POST" action="index.php?controller=auth&action=sendResetEmail">
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <!-- Email input field (required) -->
            <input type="email" class="form-control" id="email" name="email" required placeholder="tu correo">
        </div>
        <!-- Submit button to send the recovery link -->
        <button type="submit" class="btn btn-primary">Enviar enlace de recuperación</button>
    </form>
</div>
</body>
</html>

