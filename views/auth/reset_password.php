<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <!-- Import Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Restablecer contraseña</h2>
    <!-- Password reset form: sends a POST request with the new password and token -->
    <form method="POST" action="index.php?controller=auth&action=resetPassword">
        <!-- Hidden input to send the reset token -->
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva contraseña</label>
            <!-- New password input field (required) -->
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <!-- Submit button to update the password -->
        <button type="submit" class="btn btn-success">Actualizar contraseña</button>
    </form>
</div>
</body>
</html>


