<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

date_default_timezone_set('America/Sao_Paulo');

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);

$input = json_decode(file_get_contents('php://input'), true);
$user = $auth->login($input['email'], $input['password']);

if (empty($user)) {
    header("HTTP/1.0 401 Not Found");
    echo json_encode(array(
        'message' => 'Usuário e/ou senha inválidos tente novamente'
    ));
    die();
}

echo json_encode($user);