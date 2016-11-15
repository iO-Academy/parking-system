<?php

require '/Users/benmorris/Documents/Development/academy/parking-system/classes/Carpark.php';
require '/Users/benmorris/Documents/Development/academy/parking-system/vendor/autoload.php';
use PHPUnit\Framework\TestCase;


/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 15/11/2016
 * Time: 14:17
 */
class CarparkTest extends TestCase
{
    public function testSuccessfulInstantiation() {

        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'test_name',
            'capacity' => 'test_capacity',
            'isVisitor' => 1
        ]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $failed = false;
        try {
            $user = new User($mockPDO, 'test_name');
        } catch (Exception $e) {
            $failed = true;
        }
        $this->assertFalse($failed);

    }

    public function testFailedInstantiation() {
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        try {
            $user = new User($mockPDO, 'test_name');
        } catch (Exception $e) {
            
        }

    }

}