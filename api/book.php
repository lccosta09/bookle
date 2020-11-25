<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$dbh = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');

$input = json_decode(file_get_contents('php://input'), true);
