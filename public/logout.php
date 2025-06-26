<?php
session_start();
session_unset();     // Limpia variables de sesión
session_destroy();   // Destruye la sesión

// Redirige a la página principal o al login
header("Location: index.php");
exit;
