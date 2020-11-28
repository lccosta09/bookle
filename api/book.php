<?php
require_once 'cors.php';
$cors = new Cors();
$cors->setHeaders();

date_default_timezone_set('America/Sao_Paulo');

$dbh = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');
$input = json_decode(file_get_contents('php://input'), true);
$sql = "SELECT schedules.doctor_id, schedules.starts_at, schedules.ends_at
        FROM schedules
        WHERE schedules.id = {$input['scheduleId']}
        LIMIT 1";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$schedule = $stmt->fetch();
if (empty($schedule)) {
    header("HTTP/1.0 403 Not Found");
    echo json_encode(array(
        'message' => 'Horário indisponível'
    ));
    die();
}

$sql = "SELECT COUNT(appointments.id) AS booked_appointments
        FROM appointments
        INNER JOIN schedules ON (appointments.schedule_id = schedules.id)
        WHERE appointments.user_id = {$input['userId']}
        AND schedules.doctor_id = {$schedule['doctor_id']}
        AND schedules.starts_at >= '" . date('Y-m-d H:i') . "'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$appointments = $stmt->fetch();
if ($appointments['booked_appointments'] > 0) {
    header("HTTP/1.0 403 Not Found");
    echo json_encode(array(
        'message' => 'Você já possui uma consulta marcada com este médico'
    ));
    die();
}

$sql = "SELECT COUNT(appointments.id) AS booked_appointments, schedules.appointments_limit
        FROM schedules
        LEFT JOIN appointments ON (schedules.id = appointments.schedule_id)
        WHERE schedules.id = {$input['scheduleId']}";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$appointments = $stmt->fetch();
if ($appointments['booked_appointments'] == $appointments['appointments_limit']) {
    header("HTTP/1.0 403 Not Found");
    echo json_encode(array(
        'message' => 'Horário indisponível'
    ));
    die();
}

$sql = "SELECT COUNT(appointments.id) AS booked_appointments
        FROM appointments
        INNER JOIN schedules ON (appointments.schedule_id = schedules.id)
        WHERE schedules.starts_at >= '{$schedule['starts_at']}'
        AND schedules.ends_at <= '{$schedule['ends_at']}'
        AND appointments.user_id = {$input['userId']}";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$appointments = $stmt->fetch();
if ($appointments['booked_appointments'] > 0) {
    header("HTTP/1.0 403 Not Found");
    echo json_encode(array(
        'message' => 'Você já possui uma consulta marcada neste horário'
    ));
    die();
}

try {
    $sql = "INSERT INTO appointments (schedule_id, user_id) VALUES (?, ?)";
    $stmt= $dbh->prepare($sql);
    $stmt->execute([$input['scheduleId'], $input['userId']]);
} catch (Exception $e) {
    header("HTTP/1.0 403 Not Found");
    echo json_encode(array(
        'message' => 'Não foi possível agendar sua consulta, tente novamente mais tarde'
    ));
    die();
}

echo json_encode($input);