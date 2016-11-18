<?php

require __DIR__ . '/../../classes/User.php';
require __DIR__ . '/../../autoload.php';
use PHPUnit\Framework\TestCase;

/**
 * Call protected/private method of a class.
 *
 * @param object &$object    Instantiated object that we will run method on.
 * @param string $methodName Method name to call
 * @param array  $parameters Array of parameters to pass into method.
 *
 * @return mixed Method return.
 */
function invokeMethod(&$object, $methodName, array $parameters = array())
{
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);
    return $method->invokeArgs($object, $parameters);
}

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

    /**
     * Tests that add user returns pdo error code
     */
    public function testSetAddUserReturnsPdoErrorCode() {
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('errorCode')->willReturn('00000');
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $user = new User($mockPDO);

        $this->assertEquals('00000', $user->addUser([])); // 4 Digit int
    }

    /**
     * Tests that the setAddUserDataDefaults() removes keys that shouldn't be there
     */
    public function testSetAddUserDataDefaultsRemovesInappropriateKeys() {
        $mockPDO = $this->createMock('PDO');
        $user = new User($mockPDO);
        $result = invokeMethod($user, 'setAddUserDataDefaults', [['id' => 7]]);
        $this->assertFalse(isset($result['id'])); // 4 Digit int
    }

    /**
     * Tests that the setAddUserDataDefaults() preserves keys that should be there
     */
    public function testSetAddUserDataDefaultsPreservesProvidedHash() {
        $mockPDO = $this->createMock('PDO');
        $user = new User($mockPDO);
        $result = invokeMethod($user, 'setAddUserDataDefaults', [['hash' => 1234]]);

        $this->assertEquals(1234, $result['hash']); // 4 Digit int
    }

    /**
     * Tests that the setAddUserDataDefaults() adds keys that aren't present
     */
    public function testSetAddUserDataDefaultsCreatesMissingKeys() {
        $mockPDO = $this->createMock('PDO');
        $user = new User($mockPDO);
        $result = invokeMethod($user, 'setAddUserDataDefaults', [[]]);

        $this->assertEquals(2, $result['department']);
        $this->assertInternalType('int', $result['hash']); // 4 Digit int
        $this->assertLessThanOrEqual(9999, $result['hash']);
        $this->assertGreaterThanOrEqual(1000, $result['hash']);
    }

    /**
     * Tests that the setAddUserDataDefaults() hashes passwords correctly
     */
    public function testSetAddUserDataHashesPasswords() {
        $mockPDO = $this->createMock('PDO');
        $user = new User($mockPDO);
        $result = invokeMethod($user, 'setAddUserDataDefaults', [['password' => 'examplepassword', 'hash' => 1234]]);
        $this->assertEquals(sha1(1234 . 'examplepassword'), $result['password']);
    }


// These weren't very testable functions as they don't output anything
// public function login()
// public function testChangeEmail()
// public function testChangePassword()

//TODO: public function __construct()
//TODO: public function validateToken()

}