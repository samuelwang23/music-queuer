<?php


namespace Neoan3\Apps;


use Exception;

/**
 * Class StatelessOOP
 * @package Neoan3\Apps
 */
class StatelessOOP
{
    /**
     * StatelessOOP constructor.
     * @param string | null $secret
     * @param string | null $jwt
     */
    public function __construct($secret = null, $jwt = null)
    {
        if($jwt){
            $this->setAuthorization($jwt);
        }
        if($secret){
            $this->setSecret($secret);
        }
    }

    /**
     * @param $id
     * @param $scope
     * @param array $payload
     * @return string
     * @throws Exception
     */
    function assign($id, $scope, $payload = [])
    {
        return Stateless::assign($id, $scope, $payload);
    }

    /**
     * @param $string
     */
    function setSecret($string)
    {
        Stateless::setSecret($string);
    }

    /**
     * @param null $scope
     * @return mixed|string
     * @throws Exception
     */
    function restrict($scope = null)
    {
        return Stateless::restrict($scope);
    }

    /**
     * @param $exceptionClass
     */
    function setCustomException($exceptionClass)
    {
        Stateless::setCustomException($exceptionClass);
    }

    /**
     * @param null $jwt
     * @return mixed|string
     * @throws Exception
     */
    function validate($jwt = null)
    {
        if($jwt){
            self::setAuthorization($jwt);
        }
        return Stateless::validate();
    }

    /**
     * @param string $jwt
     */
    function setAuthorization(string $jwt)
    {
        Stateless::setAuthorization($jwt);
    }
}