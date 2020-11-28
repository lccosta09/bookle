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

$conn = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');

$sql = "SELECT doctors.id, users.name, doctors.description, addresses.address, addresses.number, addresses.zipcode, addresses.neighborhood, addresses.city, addresses.state
    FROM users
    INNER JOIN doctors ON (users.id = doctors.user_id)
    INNER JOIN addresses ON (users.id = addresses.user_id)";
$data = $conn->query($sql);
$response = [];
foreach ($data as $doctor) {
    $doctor['headers'] = getallheaders();
    $response[] = $doctor;
}
echo json_encode($response);