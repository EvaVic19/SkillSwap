<?php
// Encabezados para permitir peticiones y devolver JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/database.php';

$db = Database::connect();

// Consulta SQL para obtener usuarios (excluyendo contraseñas por seguridad)
$sql = "SELECT id, name, email, role, skill, about FROM users";

$stmt = $db->prepare($sql);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los datos como JSON
echo json_encode($usuarios);
