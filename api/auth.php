<?php

class Auth
{
    private $jwt;

    public function __construct($jwt)
    {
        $this->jwt = $jwt;
    }

    public function auth()
    {
        $token = $this->getToken();
        return $this->jwt->isValid($token);
    }

    public function refreshToken()
    {

    }

    private function getToken()
    {
        $token = $this->getHeaderValue('Authorization');
        $token = $token ?? $this->getServerEntryValue('HTTP_AUTHORIZATION');
        $isBearerPrefixed = preg_match('/^(Bearer[\s]{1,})(.+)/', $token, $match);
        return $isBearerPrefixed ? $match[2] : null;
    }

    private function getRefreshToken()
    {
        $refreshToken = $this->getServerEntryValue('HTTP_COOKIE');
        $refreshToken = $refreshToken ?? $this->getHeaderValue('Cookie');
        $isRefreshTokenPresent = preg_match('/(^|[;]{0,})(refreshToken=)(.+)($|[;]{0,})/', $refreshToken, $match);
        return $isRefreshTokenPresent ? urldecode($match[3]) : null;
    }

    private function getHeaderValue($key)
    {
        $headers = getallheaders();
        $keyToLower = strtolower($key);

        if (empty($headers[$key]) && empty($headers[$keyToLower])) {
            return null;
        }

        return $headers[$key] ?? $headers[$keyToLower];
    }

    private function getServerEntryValue($key)
    {
        return $_SERVER[$key] ?? null; 
    }
}