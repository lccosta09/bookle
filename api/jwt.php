<?php

class JWT {

    private $secret = 'SantaMaria12';

    public function encode($payload, $expiresAt) {
        $header = [
           'alg' => 'HS256',
           'typ' => 'JWT'
        ];

        $payload['exp'] = $expiresAt;

        $header = json_encode($header);
        $header = base64_encode($header);

        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $this->secret, true);
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    public function decode($token) {
        $part = explode('.', $token);
        if (count($part) !== 3) {
            return false;
        }

        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $decodePayload = json_decode(base64_decode($payload));
        if (!is_array($decodePayload) || !isset($decodePayload['exp'])) {
            return false;
        }

        $valid = hash_hmac('sha256', "$header.$payload", $this->secret, true);
        $valid = base64_encode($valid);

        return $signature == $valid && $decodePayload['exp'];
    }

    public function getRefreshToken($payload, $expiresAt) {
        $bytes = random_bytes(20);
        $payload['uuid'] = bin2hex($bytes);
        return $this->encode($payload, $expiresAt);
    }
}