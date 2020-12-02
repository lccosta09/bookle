<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

date_default_timezone_set('America/Sao_Paulo');

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);

if (!$auth->logout()) {
	header("HTTP/1.0 401 Not Found");
	echo json_encode(array(
		'message' => 'Não foi possível encerrar sua sessão, tente novamente'
	));
	die();
}

echo json_encode(array(
	'message' => 'Sua sessão foi encerrada')
);