<?php 

// Cargar Composer autoload correctamente (sube solo un nivel)
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar controlador y acción desde la URL
$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Convertir a clase
$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            echo "❌ Acción '$action' no encontrada.";
        }
    } else {
        echo "❌ Clase '$controllerClass' no encontrada.";
    }
} else {
    echo "❌ Controlador '$controllerClass' no encontrado.";
}

