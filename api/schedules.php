<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$conn = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');

$conditions = [];

if (!empty($_GET['doctorId'])) {
    $conditions[] = "doctor_id = {$_GET['doctorId']}";
}

if (!empty($_GET['month'])) {
    $conditions[] = "MONTH(start_hour) = {$_GET['month']}";
}

if (!empty($_GET['date'])) {
    $conditions[] = "start_hour >= '{$_GET['date']} 00:00:00'";
    $conditions[] = "start_hour <= '{$_GET['date']} 23:59:59'";
}

$conditions[] = !empty($_GET['year']) ? "YEAR(start_hour) = {$_GET['year']}" : 'YEAR(start_hour) = ' . date('Y');

$conditions = implode(' AND ', $conditions);

$sql = "SELECT doctors.id, schedules.start_hour, schedules.end_hour, schedules.appointments_limit
    FROM schedules INNER JOIN doctors ON (schedules.doctor_id = doctors.id)
    WHERE $conditions";
$data = $conn->query($sql);
$response = [];
foreach ($data as $schedule) {
    $time = strtotime(date('D M d Y 00:00:00 O', strtotime($schedule['start_hour']))) . '000';
    $response[$schedule['id']][$time][] = [
        'start' => date('H:i', strtotime($schedule['start_hour'])),
        'end' => date('H:i', strtotime($schedule['end_hour'])),
        'date' => date('Y-m-d', strtotime($schedule['start_hour'])),
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