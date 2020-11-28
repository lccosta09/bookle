<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);
if (!$auth->validate()) {
    header("HTTP/1.0 401 Not Found");
    echo json_encode(array(
        'message' => 'Usuário não autenticado'
    ));
    die();
}

date_default_timezone_set('America/Sao_Paulo');

$conn = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');

$sql = "SELECT doctors.id, users.name, doctors.description, addresses.address, addresses.number, addresses.zipcode, addresses.neighborhood, addresses.city, addresses.state
    FROM users
    INNER JOIN doctors ON (users.id = doctors.user_id)
    INNER JOIN addresses ON (users.id = addresses.user_id)";
$data = $conn->query($sql);
$response = [];
foreach ($data as $doctor) {
    $response[] = $doctor;
}
echo json_encode($response);