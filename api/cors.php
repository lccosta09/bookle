<?php

class Cors
{
    public function setHeaders()
    {
         if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header('Access-Control-Allow-Origin: http://localhost:1414');
            header('Access-Control-Allow-Credentials: true');
            header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
            header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
            die();
        }

        header('Access-Control-Allow-Origin: http://localhost:1414');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Content-Type: application/json');       
    }
}