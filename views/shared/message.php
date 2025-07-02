<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje</title>
    <!-- Import Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Automatic redirect after 4 seconds to the specified URL -->
    <meta http-equiv="refresh" content="4;url=<?php echo $redirectUrl; ?>">
</head>
<body class="bg-light">
<div class="container mt-5">
    <!-- Display the dynamic message with the corresponding alert type -->
    <div class="alert alert-<?php echo $type; ?>">
        <?php echo $message; ?>
    </div>
    <!-- Inform the user about the automatic redirection and provide a manual link -->
    <p>Serás redirigido automáticamente... Si no, <a href="<?php echo $redirectUrl; ?>">haz clic aquí</a>.</p>
</div>
</body>
</html>

