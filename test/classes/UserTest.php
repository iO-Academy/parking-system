<?php

require __DIR__ . '/../../classes/User.php';
require __DIR__ . '/../../autoload.php';
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    /**
     * Tests validateDetails() returns true when validating an existing email and password combination.
     */
    public function testSuccessfulValidateDetails() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1('1' . 'aaa')
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);

        $this->assertTrue($user->validateDetails('example@gmail.com','aaa'));

    }

    /**
     * Tests that the expected error will be thrown while trying to validate an email which doesn't exist.
     */
    public function testNonExistantUserValidateDetails() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);
        try {
            $user->validateDetails('example@gmail.com','aaa');
        } catch (Exception $e) {
            $this->assertEquals('user does not exist', $e->getMessage());
        }
    }

    /**
     * Tests that the correct error will be thrown while trying to validate using an existing email but an incorrect password.
     */
    public function testIncorrectPasswordValidateDetails() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1('1' . 'aab')
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);
        try {
            $user->validateDetails('example@gmail.com','aaa');
        } catch (Exception $e) {
            $this->assertEquals('incorrect email and password combination', $e->getMessage());
        }
    }

// These weren't very testable functions as they don't output anything
// public function login()
// public function testChangeEmail()
// public function testChangePassword()

//TODO: public function __construct()
//TODO: public function validateToken()

}