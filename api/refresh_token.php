<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);
$user = $auth->getUserFromRefreshToken();
$token = $auth->refreshToken();

if (empty($token) || empty($user)) {
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