<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:1414');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
    header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
    die();
}

header('Access-Control-Allow-Origin: http://localhost:1414');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$response = array('date' => strtotime(date('D M d Y 00:00:00 O')) . '000');
echo json_encode($response);