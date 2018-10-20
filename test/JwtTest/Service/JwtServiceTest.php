<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jwt\Service\JwtService;

class JwtServiceTest extends TestCase {

    private $service;
    private Const REGEX_TOKEN = '/^[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+?\.([a-zA-Z0-9\-_]+)?$/';

    public function setUp() : void {
        $this->service = new JwtService();
    }

    private function getService() : JwtService {
        return $this->service;
    }

    public function testInstanceOfJwtService() : void {
        $this->assertInstanceOf(JwtService::class, $this->getService());
    }

    public function testGetToken() : String {
        $data   = ['test'];
        $token  = $this->getService()->signIn($data);

        $this->assertRegExp(self::REGEX_TOKEN, $token);

        return $token;
    }

    /**
    * @depends testGetToken
    **/
    public function testCheckValidToken(String $token) : void {
        $this->assertTrue($this->getService()->checkToken($token));
    }

    /**
    * @depends testGetToken
    * @expectedException Jwt\Exception\InvalidTokenSuppledException
    **/
    public function testCheckMethodWhenEmptyReturnAnError(String $token) : void {
        $this->assertTrue($this->getService()->checkToken());
    }

    /**
    * @depends testGetToken
    * @expectedException Jwt\Exception\InvalidUserLoggedInExcetion
    **/
    public function testCheckMethodWhenInvalidUserLoggedInReturnAnError(String $token) : void {
        $this->assertTrue($this->getService()->changeAud()->checkToken($token));
    }

    /**
    * @depends testGetToken
    **/
    public function testGetDataToken (String $token) : void {
        $expectData = ['test'];

        $actualData = $this->getService()->getData($token);

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectData),
            json_encode($actualData)
        );
    }

  }
