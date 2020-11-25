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

$sql = "SELECT users.id, users.email, users.name, users.user_password
        FROM users
        WHERE users.email = '{$input['email']}'
        LIMIT 1";

$stmt = $dbh->prepare($sql); 
$stmt->execute(); 
$user = $stmt->fetch();

if (empty($user)) {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(array(
        'message' => 'Usuário e/ou senha inválidos tente novamente'
    ));
    exit();
}

if (md5($input['password']) != $user['user_password']) {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(array(
        'message' => 'Usuário e/ou senha inválidos tente novamente'
    ));
    exit();    
}

echo json_encode(array(
    'id' =>  $user['id'],
    'name' =>  $user['name'],
    'email' =>  $user['email']
));