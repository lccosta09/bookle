<?php

class JWT
{
    public function encode($payload, $expiresAt, $secret = null)
    {
        $header = [
           'alg' => 'HS256',
           'typ' => 'JWT'
        ];

        $bytes = random_bytes(20);
        $payload['uuid'] = bin2hex($bytes);
        $payload['iat'] = time();
        $payload['exp'] = $expiresAt;

        $header = json_encode($header);
        $header = base64_encode($header);

        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    public function decode($token, $secret)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return [];
        }

        list($header, $payload, $signature) = $parts;
        return json_decode(base64_decode($payload), true);
    }

    public function isValid($token, $secret)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return [];
        }

        list($header, $payload, $signature) = $parts;
        $decodePayload = json_decode(base64_decode($payload), true);

        if (!is_array($decodePayload) || !isset($decodePayload['exp'])) {
            return false;
        }

        $valid = hash_hmac('sha256', "$header.$payload", $secret, true);
        $valid = base64_encode($valid);

        return $signature == $valid && $decodePayload['exp'] >= time();
    }
}