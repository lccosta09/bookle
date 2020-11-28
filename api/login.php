<?php
require_once 'cors.php';
$cors = new Cors();
$cors->setHeaders();

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
