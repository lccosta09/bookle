<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');
$response = array('date' => strtotime(date('D M d Y 00:00:00 O')) . '000');
echo json_encode($response);