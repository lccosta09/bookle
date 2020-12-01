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

    public function login($email, $password) {
        $sql = "SELECT users.id, users.email, users.name, users.user_password
                FROM users
                WHERE users.email = '$email'
                LIMIT 1";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetch();

        if (empty($user)) {
            return [];
        }

        if (md5($password) != $user['user_password']) {
            return [];
        }

        return [
            'id' =>  $user['id'],
            'name' =>  $user['name'],
            'email' =>  $user['email'],
            'token' => $this->getToken($user['id'])
        ];
    }

    public function refreshToken()
    {
        $refreshToken = $this->getRefreshTokenFromCookie();

        if (empty($refreshToken)) {
            setcookie('refreshToken', null, strtotime('-1 hour'), null, null, false, true);
            return [];
        }

        $refreshToken = addslashes($refreshToken);

        $sql = "SELECT auth.id AS auth_id, users.id, users.email, users.name, users.user_password
                FROM auth INNER JOIN users ON (auth.user_id = users.id)
                AND refresh_token = '$refreshToken'
                LIMIT 1";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetch();

        if (empty($user)) {
            setcookie('refreshToken', null, strtotime('-1 hour'), null, null, false, true);
            return [];
        }

        $sql = "DELETE FROM auth WHERE id = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$user['auth_id']]);

        return [
            'id' =>  $user['id'],
            'name' =>  $user['name'],
            'email' =>  $user['email'],
            'token' => $this->getToken($user['id'])
        ];
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

    private function getToken($userId)
    {
        $token = $this->jwt->encode(['sub' => $userId], strtotime('+15 minutes'), $this->tokenSecret);

        $refreshTokenExpiration = strtotime('+30 days');
        $refreshToken = $this->jwt->encode(['sub' => $userId], $refreshTokenExpiration, $this->refreshTokenSecret);

        $sql = "INSERT INTO auth (token, refresh_token, user_id, expires_at) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$token, $refreshToken, $userId, date('Y-m-d H:i:s')]);

        setcookie('refreshToken', $refreshToken, $refreshTokenExpiration, null, null, false, true);

        return $token;
    }

    private function getTokenFromHeader($validate = true)
    {
        $token = $this->getHeaderValue('Authorization');
        $token = $token ?? $this->getServerEntryValue('HTTP_AUTHORIZATION');
        $isBearerPrefixed = preg_match('/^(Bearer[\s]{1,})(.+)/', $token, $match);
        $token = $isBearerPrefixed ? $match[2] : null;
        return !$validate || $this->jwt->isValid($token, $this->tokenSecret) ? $token : null;
    }

    private function getRefreshTokenFromCookie($validate = true)
    {
        if (!empty($_COOKIE['refreshToken'])) {
            return !$validate || $this->jwt->isValid($_COOKIE['refreshToken'], $this->refreshTokenSecret) ? $_COOKIE['refreshToken'] : null;
        }

        $refreshToken = $this->getServerEntryValue('HTTP_COOKIE');
        $refreshToken = $refreshToken ?? $this->getHeaderValue('Cookie');
        $isRefreshTokenPresent = preg_match('/(^|[;]{0,})(refreshToken=)(.+)($|[;]{0,})/', $refreshToken, $match);
        $refreshToken = $isRefreshTokenPresent ? urldecode($match[3]) : null;
        return !$validate || $this->jwt->isValid($refreshToken, $this->refreshTokenSecret) ? $refreshToken : null;
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