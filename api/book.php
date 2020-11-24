<?php
session_start();

$appointments = [
    'id' => 7,
    'doctor' => 1,
    'date' => '2020-11-25',
    'start' => '09:30',
    'end' => '10:00'
];

$input = file_get_contents('php://input');
$input = json_decode($input, true);

$doctorAppointments = array($appointments, function($appointments) use ($input) {
    
});

