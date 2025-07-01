<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/MatchModel.php';

$matchModel = new MatchModel();
$matches = $matchModel->getAll();  

echo json_encode($matches, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
