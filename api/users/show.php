<?php
// Mostrar un usuario por ID en formato JSON
header('Content-Type: application/json');

// Validar que venga el parámetro ?id
if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Falta el parámetro 'id'"]);
    exit;
}

$id = $_GET['id'];

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/User.php';

$userModel = new User();
$user = $userModel->find($id);

if ($user) {
    echo json_encode($user, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}
