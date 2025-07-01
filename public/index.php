<?php
$controllerName = $_GET['controller'] ?? 'Home';
$action = $_GET['action'] ?? 'index';

// Si la acción viene por POST, también la aceptamos:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controllerName = $_POST['controller'] ?? $controllerName;
    $action = $_POST['action'] ?? $action;
}

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $action)) {
            // Pasamos el parámetro id por GET (solo si existe)
            if (isset($_GET['id'])) {
                $controller->$action($_GET['id']);
            } else {
                $controller->$action();
            }
        } else {
            echo "❌ Acción '<strong>$action</strong>' no encontrada en el controlador '$controllerClass'.";
        }
    } else {
        echo "❌ Clase de controlador '<strong>$controllerClass</strong>' no encontrada.";
    }
} else {
    echo "❌ Archivo del controlador '<strong>$controllerFile</strong>' no encontrado.";
}



