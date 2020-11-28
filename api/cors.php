<?php

class Cors
{
    private $allowedOrigins = [
        'http://localhost:1414',
        'http://bookle.docker:1212'
    ];

    public function setHeaders()
    {
        $allowedOrigin = $this->getAllowedOrigin();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header('Access-Control-Allow-Origin: ' . $allowedOrigin);
            header('Access-Control-Allow-Credentials: true');
            header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
            header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
            die();
        }

        header('Access-Control-Allow-Origin: ' . $allowedOrigin);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Content-Type: application/json');
    }

    private function getAllowedOrigin()
    {
        $origin = null;
        $headers = getallheaders();

        foreach (['Origin'] as $header) {
            $headerToLower = strtolower($header);
            if (!empty($headers[$header]) || !empty($headers[$headerToLower])) {
                $origin = $headers[$header] ?? $headers[$headerToLower];
                break;
            }
        }

        if (!empty($origin)) {
            $origin = $_SERVER['HTTP_ORIGIN'] ?? $origin;
        }

        return in_array($origin, $this->allowedOrigins) ? $origin : '';
    }
}