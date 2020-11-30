<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);
$token = $auth->refreshToken();

if (empty($token)) {
    header("HTTP/1.0 401 Not Found");
    echo json_encode(array(
        'message' => 'Usuário não autenticado'
    ));
    die();
}

$dbh = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');
$decodedToken = $auth->decodeToken($token);

$sql = "SELECT users.id, users.email, users.name, users.user_password
        FROM users
        WHERE users.id = {$decodedToken['sub']}
        LIMIT 1";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$user = $stmt->fetch();

if (empty($user)) {
    header("HTTP/1.0 401 Not Found");
    echo json_encode(array(
        'message' => 'Usuário não autenticado'
    ));
    die();
}

echo json_encode(array(
    'id' =>  $user['id'],
    'name' =>  $user['name'],
    'email' =>  $user['email'],
    'token' => $token
));