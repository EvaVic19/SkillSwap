<?php
// api/matches/create.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Solo se permiten solicitudes POST']);
    exit;
}

// Recibir y decodificar JSON desde el cuerpo de la solicitud
$input = json_decode(file_get_contents('php://input'), true);

// Verificar campos obligatorios
if (!isset($input['skill_id']) || !isset($input['matched_user_id'])) {
    echo json_encode(['error' => 'Faltan datos requeridos: skill_id y matched_user_id']);
    exit;
}

$skill_id = $input['skill_id'];
$matched_user_id = $input['matched_user_id'];

// Conectar a la base de datos y llamar al modelo
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/MatchModel.php';

$matchModel = new MatchModel();
$resultado = $matchModel->crear($skill_id, $matched_user_id);

if ($resultado) {
    echo json_encode(['mensaje' => 'Match creado exitosamente']);
} else {
    echo json_encode(['error' => 'No se pudo crear el match']);
}
