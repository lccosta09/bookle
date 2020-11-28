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
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

require_once 'jwt.php';

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
    die();
}

if (md5($input['password']) != $user['user_password']) {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(array(
        'message' => 'Usuário e/ou senha inválidos tente novamente'
    ));
    die();
}

$jwt = new JWT();
$token = $jwt->encode(['sub' => $user['email']], strtotime('+15 minutes'));
$refreshTokenExpiration = strtotime('+30 days');
$refreshToken = $jwt->getRefreshToken(['sub' => $user['email']], $refreshTokenExpiration);

setcookie('refreshToken', $refreshToken, $refreshTokenExpiration, null, null, false, true);

echo json_encode(array(
    'id' =>  $user['id'],
    'name' =>  $user['name'],
    'email' =>  $user['email'],
    'token' => $token
));
