<?php
sleep(2);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$response = [
    [
        'id' => 1,
        'name' => 'Edilaine de Olveira Miguel',
        'address' => 'Av. Rio Branco',
        'number' => '1357',
        'zipcode' => '17526-693',
        'neighborhood' => 'Alto Cafezal',
        'city' => 'Marília',
        'state' => 'SP',
        'description' => 'Clínico geral com mais de 10 anos de experiência.'
    ],
    [
        'id' => 2,
        'name' => 'Benedito Pilon',
        'address' => 'Rua Vinte e um de abril',
        'number' => '143',
        'zipcode' => '17516-170',
        'neighborhood' => 'Jardim Maria Izabel',
        'city' => 'Marília',
        'state' => 'SP',
        'description' => 'Cirurgião geral, gastroenterologista e coloproctologista com mais de 30 anos de experiência'
    ],
    [
        'id' => 3,
        'name' => 'Gisele Nicolielo Soria',
        'address' => 'Av.Rio Branco',
        'number' => '1132',
        'zipcode' => '17502-000',
        'neighborhood' => 'Alto Cafezal',
        'city' => 'Marília',
        'state' => 'SP',
        'description' => 'Ginecologista e Obstetra atendendo Marília e região'
    ],
    [
        'id' => 4,
        'name' => 'Gisele César de Rossi',
        'address' => 'Av.Cascata',
        'number' => '47',
        'zipcode' => '17515-300',
        'neighborhood' => 'Jardim Maria Izabel',
        'city' => 'Marília',
        'state' => 'SP',
        'description' => 'Pneumologista atendendo em Marília e região ha 25 anos'
    ]
];

echo json_encode($response);