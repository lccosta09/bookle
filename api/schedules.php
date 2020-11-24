<?php
sleep(2);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$schedules = [
    [
        'id' => 1,
        'doctorId' => 1,
        'date' => '2020-11-16',
        'start' => '09:30',
        'end' => '10:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 2,
        'doctorId' => 1,
        'date' => '2020-11-16',
        'start' => '14:00',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 3,
        'doctorId' => 1,
        'date' => '2020-11-16',
        'start' => '15:00',
        'end' => '15:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 4,
        'doctorId' => 1,
        'date' => '2020-11-17',
        'start' => '10:30',
        'end' => '11:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 5,
        'doctorId' => 1,
        'date' => '2020-11-17',
        'start' => '11:00',
        'end' => '11:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 6,
        'doctorId' => 1,
        'date' => '2020-11-17',
        'start' => '13:30',
        'end' => '14:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 7,
        'doctorId' => 1,
        'date' => '2020-11-25',
        'start' => '09:30',
        'end' => '10:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 8,
        'doctorId' => 1,
        'date' => '2020-11-25',
        'start' => '14:00',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 9,
        'doctorId' => 1,
        'date' => '2020-11-25',
        'start' => '15:00',
        'end' => '15:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 10,
        'doctorId' => 1,
        'date' => '2020-11-26',
        'start' => '10:30',
        'end' => '11:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 11,
        'doctorId' => 1,
        'date' => '2020-11-26',
        'start' => '11:00',
        'end' => '11:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 12,
        'doctorId' => 1,
        'date' => '2020-11-26',
        'start' => '13:30',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 13,
        'doctorId' => 1,
        'date' => '2020-12-01',
        'start' => '11:30',
        'end' => '12:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 14,
        'doctorId' => 1,
        'date' => '2020-12-01',
        'start' => '13:00',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 15,
        'doctorId' => 1,
        'date' => '2020-12-01',
        'start' => '15:30',
        'end' => '16:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 1,
        'doctorId' => 2,
        'date' => '2020-11-16',
        'start' => '09:30',
        'end' => '10:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 2,
        'doctorId' => 2,
        'date' => '2020-11-16',
        'start' => '14:00',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 3,
        'doctorId' => 2,
        'date' => '2020-11-16',
        'start' => '15:00',
        'end' => '15:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 4,
        'doctorId' => 2,
        'date' => '2020-11-17',
        'start' => '10:30',
        'end' => '11:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 5,
        'doctorId' => 2,
        'date' => '2020-11-17',
        'start' => '11:00',
        'end' => '11:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 6,
        'doctorId' => 2,
        'date' => '2020-11-17',
        'start' => '13:30',
        'end' => '14:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 7,
        'doctorId' => 2,
        'date' => '2020-11-25',
        'start' => '09:30',
        'end' => '10:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 8,
        'doctorId' => 2,
        'date' => '2020-11-25',
        'start' => '14:00',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 9,
        'doctorId' => 2,
        'date' => '2020-11-25',
        'start' => '15:00',
        'end' => '15:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 10,
        'doctorId' => 2,
        'date' => '2020-11-26',
        'start' => '10:30',
        'end' => '11:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 11,
        'doctorId' => 2,
        'date' => '2020-11-26',
        'start' => '11:00',
        'end' => '11:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 12,
        'doctorId' => 2,
        'date' => '2020-11-26',
        'start' => '13:30',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 13,
        'doctorId' => 2,
        'date' => '2020-12-01',
        'start' => '11:30',
        'end' => '12:00',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 14,
        'doctorId' => 2,
        'date' => '2020-12-01',
        'start' => '13:00',
        'end' => '14:30',
        'appointmentsLimit' => 1
    ],
    [
        'id' => 15,
        'doctorId' => 2,
        'date' => '2020-12-01',
        'start' => '15:30',
        'end' => '16:00',
        'appointmentsLimit' => 1
    ]
];

$response = [];
foreach ($schedules as $schedule) {
    $date = strtotime($schedule['date']);
    $year = $_GET['year'] ?? date('Y');
    $month = !empty($_GET['month']) ? date('Y-m', strtotime($year . '-' . $_GET['month'] . '-01')) : null;  

    if (!empty($month) && $month != date('Y-m', $date)) {
        continue;
    }

    if (!empty($_GET['date']) && $_GET['date'] != date('Y-m-d', $date)) {
        continue;
    }

    if (!empty($_GET['doctorId']) && $_GET['doctorId'] != $schedule['doctorId']) {
        continue;
    }

    if ($date < strtotime(date('Y-m-d'))) {
        continue;
    }

    $time = strtotime(date('D M d Y 00:00:00 O', $date)) . '000';
    $response[$schedule['doctorId']][$time][] = [
        'start' => $schedule['start'],
        'end' => $schedule['end'],
        'date' => $schedule['date'],
        'appointmentsLimit' => $schedule['appointmentsLimit']
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