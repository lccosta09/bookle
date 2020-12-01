<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

date_default_timezone_set('America/Sao_Paulo');

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);
$user = $auth->refreshToken();

if (empty($user)) {
    header("HTTP/1.0 401 Not Found");
    echo json_encode(array(
        'message' => 'Usuário não autenticado'
    ));
    die();
}

echo json_encode($user);