<?php

namespace Neoan3\Apps;

use Neoan3\Core\MockRouteException;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/MockRouteException.php';

class StatelessTest extends TestCase
{
    private StatelessOOP $instance;
    public static function setUpBeforeClass(): void
    {
        if(!defined('base')){
            define('base', 'http://localhost/test');
        }

    }
    protected function setUp(): void
    {
        Stateless::setSecret('secret');
        Stateless::setCustomException(MockRouteException::class);
        $this->instance = new StatelessOOP();
        $this->instance->setSecret('secret');
        $this->instance->setCustomException(\Neoan3\Core\MockRouteException::class);
    }

    private function setAuth($jwt): void
    {

        $_SERVER['HTTP_AUTHORIZATION'] = 'baerer ' . $jwt ;
    }

    public function testValidate()
    {
        $jwt = Stateless::assign('123',['read','write']);
        $this->setAuth($jwt);
        $receive = Stateless::validate();
        $this->assertSame('123', $receive['jti']);
    }
    public function testFail()
    {
        $jwt = Stateless::assign('123',['read','write']);
        $this->setAuth($jwt);
        // create unmatched secret
        Stateless::setSecret('secret2');
        $this->expectException(MockRouteException::class);
        Stateless::validate();
    }


    public function testRestrict()
    {
        $jwt = Stateless::assign('123',['read','write']);
        $this->setAuth($jwt);
        $receive = Stateless::restrict('read');
        $this->assertSame('123', $receive['jti']);
        $this->expectException(MockRouteException::class);
        Stateless::restrict(['admin']);
    }
    public function testAuthNotPresent()
    {
        $jwt = Stateless::assign('123',['read','write']);
        // 1. expect 401 when auth not present
        unset($_SERVER['HTTP_AUTHORIZATION']);
        $this->expectException(MockRouteException::class);
        Stateless::validate();

    }

    public function testAuthMalformed()
    {
        $jwt = Stateless::assign('123', ['read', 'write']);

        // 2. expect 401 when auth not correct format
        $_SERVER['HTTP_AUTHORIZATION'] = 'token' . $jwt;
        $this->expectException(MockRouteException::class);
        Stateless::validate();
    }
    public function testSecretNotSet()
    {
        Stateless::setSecret(null);
        $this->expectException(MockRouteException::class);
        Stateless::validate();
    }
    public function testNoCustomException()
    {
        Stateless::setCustomException(null);
        $this->expectException(\Exception::class);
        Stateless::validate();
    }

    public function testOOPRestrict()
    {
        $this->expectException(\Neoan3\Core\MockRouteException::class);
        $this->instance->restrict();
    }



    public function testOOPSetAuthorization()
    {
        $this->instance->setAuthorization($this->instance->assign('id', 'admin'));
        $jwt = $this->instance->validate();
        $this->assertSame('id', $jwt['jti']);
    }

    public function testOOPValidateJwt()
    {
        $jwt = $this->instance->validate($this->instance->assign('id', 'admin'));
        $this->assertSame('id', $jwt['jti']);
    }
    public function testOOPConstructor()
    {
        $anotherInstance = new StatelessOOP('secret', $this->instance->assign('id', 'admin'));
        $jwt = $anotherInstance->validate();
        $this->assertSame('id', $jwt['jti']);
    }

}
