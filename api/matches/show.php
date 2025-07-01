<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Falta el parámetro 'id'"]);
    exit;
}

$id = $_GET['id'];

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/MatchModel.php';

$matchModel = new MatchModel();
$match = $matchModel->find($id);  

if ($match) {
    echo json_encode($match, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "Match no encontrado"]);
}
