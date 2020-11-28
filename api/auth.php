<?php

class Auth
{
    private $jwt;

    private $dbh;

    private $tokenSecret = 'SantaMaria12';

    private $refreshTokenSecret = 'MaeDeDeus';

    public function __construct($jwt)
    {
        $this->dbh = new PDO('mysql:host=bookle-mysql.docker;dbname=bookle', 'root', 'bookle');
        $this->jwt = $jwt;
    }

    public function login($userId)
    {
        $token = $this->jwt->encode(['sub' => $userId], strtotime('+15 minutes'), $this->tokenSecret);

        $refreshTokenExpiration = strtotime('+30 minutes');
        $refreshToken = $this->jwt->encode(['sub' => $userId], $refreshTokenExpiration, $this->refreshTokenSecret);

        $sql = "INSERT INTO auth (token, refresh_token, user_id, expires_at) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$token, $refreshToken, $userId, date('Y-m-d H:i:s')]);

        setcookie('refreshToken', $refreshToken, $refreshTokenExpiration, null, null, false, true);

        return $token;
    }

    public function refreshToken()
    {
        $refreshToken = $this->getRefreshTokenFromCookie();
        if (empty($refreshToken)) {
            setcookie('refreshToken', null, strtotime('-1 hour'), null, null, false, true);
            return null;
        }

        $refreshToken = addslashes($refreshToken);

        $sql = "SELECT id, user_id
                FROM auth
                WHERE refresh_token = '$refreshToken'
                LIMIT 1";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $auth = $stmt->fetch();

        if (empty($auth)) {
            setcookie('refreshToken', null, strtotime('-1 hour'), null, null, false, true);
            return null;
        }

        $sql = "DELETE FROM auth WHERE id = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$auth['id']]);

        return $this->login($auth['user_id']);
    }

    public function logout()
    {
        $refreshToken = $this->getRefreshTokenFromCookie();

        if (empty($refreshToken)) {
            setcookie('refreshToken', null, strtotime('-1 hour'), null, null, false, true);
            return;
        }

        $refreshToken = addslashes($refreshToken);
        $sql = "DELETE FROM auth WHERE refresh_token = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$refreshToken]);

        setcookie('refreshToken', null, strtotime('-1 hour'), null, null, false, true);
    }

    public function validate()
    {
        $token = $this->getTokenFromHeader();
        return !empty($token);
    }

    private function getTokenFromHeader()
    {
        $token = $this->getHeaderValue('Authorization');
        $token = $token ?? $this->getServerEntryValue('HTTP_AUTHORIZATION');
        $isBearerPrefixed = preg_match('/^(Bearer[\s]{1,})(.+)/', $token, $match);
        $token = $isBearerPrefixed ? $match[2] : null;
        return $this->jwt->isValid($token, $this->tokenSecret) ? $token : null;
    }

    private function getRefreshTokenFromCookie()
    {
        if (!empty($_COOKIE['refreshToken'])) {
            return $this->jwt->isValid($_COOKIE['refreshToken']) ? $_COOKIE['refreshToken'] : null;
        }

        $refreshToken = $this->getServerEntryValue('HTTP_COOKIE');
        $refreshToken = $refreshToken ?? $this->getHeaderValue('Cookie');
        $isRefreshTokenPresent = preg_match('/(^|[;]{0,})(refreshToken=)(.+)($|[;]{0,})/', $refreshToken, $match);
        $refreshToken = $isRefreshTokenPresent ? urldecode($match[3]) : null;
        return $this->jwt->isValid($refreshToken, $this->refreshTokenSecret) ? $refreshToken : null;
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