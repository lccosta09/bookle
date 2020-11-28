<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

require_once 'jwt.php';
require_once 'auth.php';

$auth->refreshToken();