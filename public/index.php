<?php
// Obtener el controlador y la acción desde la URL (GET)
$controllerName = $_GET['controller'] ?? 'Home';     // Controlador por defecto
$action = $_GET['action'] ?? 'index';                // Acción por defecto

// Construir el nombre de la clase del controlador
$controllerClass = ucfirst($controllerName) . 'Controller';

// Ruta al archivo del controlador
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

// Verificar si el archivo del controlador existe
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Verificar si la clase existe dentro del archivo
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        // Verificar si el método (acción) existe en el controlador
        if (method_exists($controller, $action)) {
            
            // Si existe el parámetro 'id' en la URL, pasarlo como argumento
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

