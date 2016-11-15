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
            $carpark = new Carpark($mockPDO, 'test_name');
        } catch (Exception $e) {
            $failed = true;
        }
        $this->assertFalse($failed);
        $this->assertEquals(1, $carpark->getId());
        $this->assertEquals('test_name', $carpark->getName());
        $this->assertEquals('test_capacity', $carpark->getCapacity());
        $this->assertEquals(1, $carpark->isVisitor());

    }

    public function testFailedInstantiation() {
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([]);
        $mockPDO->method('prepare')->willReturn($mockStatement);

        $testName = 'test_name';
        try {
            $carpark = new Carpark($mockPDO, $testName);
        } catch (Exception $e) {
            throw new Exception ('Carpark with name ' . $testName . ' does not exist in pdo.');
        }

    }

}