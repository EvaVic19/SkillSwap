<?php
// Permitir que se use desde cualquier lado (como una app móvil o web)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Conexión a la base de datos
require_once __DIR__ . '/../../config/database.php';

$db = Database::connect();

// Obtener todas las habilidades
$sql = "SELECT s.id, s.name, s.description, s.level, s.type, s.category, u.name AS user_name
        FROM skills s
        JOIN users u ON s.user_id = u.id";

$stmt = $db->prepare($sql);
$stmt->execute();
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Responder en formato JSON
echo json_encode($skills);
