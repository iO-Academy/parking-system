<?php

require '/Users/benmorris/Documents/Development/academy/parking-system/classes/User.php';
require '/Users/benmorris/Documents/Development/academy/parking-system/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public function testSuccessfulLogin() {

        // Note, details used relevant to testLogOut
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1("1" . 'aaa')
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);
        try {
            $user->login('example@gmail.com','aaa');
        } catch (Exception $e) {
        } finally {
            $this->assertTrue($user->getLoggedIn());
        }
    }

    public function testNonExistantUserLogin() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);
        try {
            $user->login('example@gmail.com','aaa');
        } catch (Exception $e) {
            $this->assertEquals("user does not exist", $e->getMessage());
        }
    }

    public function testIncorrectPasswordLogin() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1("1" . 'aab')
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $user = new User($mockPDO);
        try {
            $user->login('example@gmail.com','aaa');
        } catch (Exception $e) {
            $this->assertEquals("incorrect email and password combination", $e->getMessage());
        }
    }

    public function testLogOut() {

        // Same as testSuccessfulLogin()
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'email' => 'example@gmail.com',
            'password' => sha1("1" . 'aaa')
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $user = new User($mockPDO);
        $user->login('example@gmail.com', 'aaa'); // No try catch needed because same code as in testSuccessfulLogin()
        // End same as testSuccessfulLogin()

        $user->logOut();
        $this->assertFalse($user->getLoggedIn());
    }

// These weren't very testable functions as they don't output anything
// public function testChangeEmail()
// public function testChangePassword()

}

