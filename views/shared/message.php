<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="4;url=<?php echo $redirectUrl; ?>">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="alert alert-<?php echo $type; ?>">
        <?php echo $message; ?>
    </div>
    <p>Serás redirigido automáticamente... Si no, <a href="<?php echo $redirectUrl; ?>">haz clic aquí</a>.</p>
</div>
</body>
</html>
