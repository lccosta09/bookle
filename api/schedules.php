<?php
require_once 'cors.php';

$cors = new Cors();
$cors->setHeaders();

require_once 'jwt.php';
require_once 'auth.php';

$jwt = new JWT();
$auth = new Auth($jwt);
if (!$auth->validate()) {
    header("HTTP/1.0 401 Not Found");
    echo json_encode(array(
        'message' => 'Usuário não autenticado'
    ));
    die();
}

date_default_timezone_set('America/Sao_Paulo');

$conn = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');

$conditions = [];

if (!empty($_GET['doctorId'])) {
    $conditions[] = "doctor_id = {$_GET['doctorId']}";
}

if (!empty($_GET['month'])) {
    $conditions[] = "MONTH(starts_at) = {$_GET['month']}";
}

if (!empty($_GET['date'])) {
    $conditions[] = "starts_at >= '{$_GET['date']} 00:00:00'";
    $conditions[] = "starts_at <= '{$_GET['date']} 23:59:59'";
}

$conditions[] = !empty($_GET['year']) ? "YEAR(starts_at) = {$_GET['year']}" : 'YEAR(starts_at) = ' . date('Y');

$conditions = implode(' AND ', $conditions);

$sql = "SELECT schedules.id, schedules.doctor_id, schedules.starts_at, schedules.ends_at, schedules.appointments_limit
    FROM schedules INNER JOIN doctors ON (schedules.doctor_id = doctors.id)
    LEFT JOIN appointments ON (schedules.id = appointments.schedule_id)
    WHERE $conditions
    GROUP BY schedules.id
    HAVING COUNT(appointments.id) < schedules.appointments_limit";
$data = $conn->query($sql);
$response = [];
foreach ($data as $schedule) {
    $time = strtotime(date('D M d Y 00:00:00 O', strtotime($schedule['starts_at']))) . '000';
    $response[$schedule['doctor_id']][$time][] = [
        'id' => $schedule['id'],
        'start' => date('H:i', strtotime($schedule['starts_at'])),
        'end' => date('H:i', strtotime($schedule['ends_at'])),
        'date' => date('Y-m-d', strtotime($schedule['starts_at'])),
        'appointmentsLimit' => $schedule['appointments_limit']
    ];
}

if (!empty($_GET['doctorId'])) {
    $response = !empty($response[$_GET['doctorId']]) ? $response[$_GET['doctorId']] : [];
}

if (!empty($_GET['date'])) {
    $date = strtotime(date('D M d Y 00:00:00 O', strtotime($_GET['date']))) . '000';
    $response = !empty($response[$date]) ? $response[$date] : [];
}

echo json_encode($response);