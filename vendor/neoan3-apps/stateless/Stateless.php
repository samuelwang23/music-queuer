<?php
/* neoan3 Stateless app
*
 */

namespace Neoan3\Apps;



use Exception;

/**
 * Class Stateless
 * @package Neoan3\Apps
 */
class Stateless
{

    /**
     * @var string|null
     */
    private static ?string $_secret = null;

    /**
     * @var string|null
     */
    private static ?string $exception = null;

    private static ?string $_jwt = null;

    static function setAuthorization($jwt)
    {
        self::$_jwt = $jwt;
    }

    static function getAuthorization()
    {
        if(self::$_jwt) {
            return self::$_jwt;
        }
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            self::throwRestricted(401);
        }
        $auth = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);

        if (count($auth) !== 2) {
            self::throwRestricted(401);
        }
        return $auth[1];
    }

    /**
     * @param ?string $exception
     */
    static function setCustomException(?string $exception)
    {
        self::$exception = $exception;
    }

    /**
     * @param $secret
     */
    static function setSecret($secret)
    {
        self::$_secret = $secret;
    }


    /**
     * @return mixed|string
     * @throws Exception
     */
    static function validate()
    {
        self::isKeySet();

        $decoded = Jwt::decode(self::getAuthorization(), self::$_secret);

        if ($decoded['error']) {
            self::throwRestricted(401);
        }
        return $decoded['decoded'];
    }

    /**
     * Restricts access and return (if valid) the decoded Jwt
     *
     * @param mixed $scope
     *
     * @return mixed
     *
     * @throws Exception
     */
    static function restrict($scope = false)
    {
        self::isKeySet();
        $decoded = self::validate();


        if ($scope && isset($decoded['scope'])) {
            if (is_string($scope)) {
                $scope = [$scope];
            }

            if (!self::permissionCheck($scope, $decoded)) {
                self::throwRestricted(403);
            }
        }
        return $decoded;
    }

    static function permissionCheck($scope, $decrypted): bool
    {
        $allowed = false;
        foreach ($scope as $access) {
            if (in_array($access, $decrypted['scope'])) {
                $allowed = true;
            }
        }
        return $allowed;
    }

    /**
     * @param       $identifier
     * @param       $scope
     * @param array $payload
     *
     * @return string
     * @throws Exception
     */
    static function assign($identifier, $scope, $payload = [])
    {
        self::isKeySet();
        Jwt::identifier($identifier);
        $scope = is_string($scope) ? [$scope] : $scope;
        $payload['scope'] = $scope;
        Jwt::payLoad($payload);
        return Jwt::encode(self::$_secret);
    }


    /**
     * @param $code
     * @param string $msg
     * @throws Exception
     */
    private static function throwRestricted($code, $msg = 'access denied')
    {
        if ($code == 401) {
            $msg = 'unauthorized';
        }
        if(self::$exception){
            throw new self::$exception($msg, $code);
        } else {
            throw new Exception($msg, $code);
        }

    }


    /**
     * @throws Exception
     */
    private static function isKeySet()
    {
        if (!self::$_secret) {
            self::throwRestricted(500, 'Setup: no secret key defined for Neoan3\Apps\Stateless');
        }
    }

}
