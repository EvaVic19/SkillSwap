<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/models/MatchModel.php';

$matchModel = new MatchModel();
$matches = $matchModel->obtenerTodos();

echo json_encode([
    'status' => 'success',
    'matches' => $matches
]);
