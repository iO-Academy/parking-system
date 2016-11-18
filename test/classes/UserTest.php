<?php

require __DIR__ . '/../../classes/User.php';
require __DIR__ . '/../../autoload.php';
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    //TODO: public function __construct()

    //TODO: create mock setUserDetails function
    /**
     * Tests validateDetails() returns true when validating an existing email and password combination.
     */
    public function testSuccessfulValidateDetails() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1('1234' . 'aaa'),
            'hash' => '1234'
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

    //TODO: create mock setUserDetails function
    /**
     * Tests that the correct error will be thrown while trying to validate using an existing email but an incorrect password.
     */
    public function testIncorrectPasswordValidateDetails() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1('1234' . 'aab'),
            'hash' => '1234'
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);

        $errorMessage = '';
        try {
            $user->validateDetails('example@gmail.com','aaa');
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
        $this->assertEquals('incorrect email and password combination', $errorMessage);
    }

    //TODO: public function validateToken()

    //TODO: public function setUserDetails()


// These weren't very testable functions as they don't output anything
// public function login()
// public function testChangeEmail()
// public function testChangePassword()

// Private functions impossible to test
// private function validateEmail()

}