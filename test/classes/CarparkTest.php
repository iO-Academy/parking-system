<?php

require __DIR__ . '/../../autoload.php';
use PHPUnit\Framework\TestCase;

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

    /**
     * Tests that incrementTime works successfully when passed three numbers
     */
    public function testSuccessfulIncrementTime() {
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = new Carpark($mockPDO, $name);

        $start = 10;
        $timeMeasure = 60;
        $timeIncrement = 100;
        $newStart = $carpark->incrementTime($start, $timeMeasure, $timeIncrement);
        $this->assertEquals($newStart, 6010);
    }

    /**
     * Tests that incrementTime returns as expected when passed null
     */
    public function testFailedIncrementTime() {
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = new Carpark($mockPDO, $name);

        $start = NULL;
        $timeMeasure = NULL;
        $timeIncrement = NULL;
        $newStart = $carpark->incrementTime($start, $timeMeasure, $timeIncrement);
        $this->assertEquals($newStart, NULL);
    }

    /**
     * Tests that getTimeStampFromTime successfully splits a date time string and converts to a unix timestamp
     */
    public function testSuccessfulGetTimeStampFromTime() {
        date_default_timezone_set('Europe/London');
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = new Carpark($mockPDO, $name);

        $dateTime = '2016-11-20 20:00';
        $negative = 1;
        $result = $carpark->getTimeStampFromTime($dateTime, $negative);
        $this->assertEquals($result, 1479499199);
    }

    /**
     * Tests that getTimeStampFromTime returns expected exception when passed incorrect data
     * @expectedException     'TimeStamp conversion failure!'
     */
    public function testFailedGetTimeStampFromTime() {
        date_default_timezone_set('Europe/London');
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = new Carpark($mockPDO, $name);

        $dateTime = '-1 -1';
        $negative = 0;
        $carpark->getTimeStampFromTime($dateTime, $negative);
    }

    /**
     * Tests that getTimeStampFromDate successfully converts date-time into unix timestamp
     */
    public function testSuccessfulGetTimeStampFromDate() {
        date_default_timezone_set('Europe/London');
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = new Carpark($mockPDO, $name);

        $dateTime = '2016-11-20 20:00';
        $result = $carpark->getTimeStampFromDate($dateTime);
        $this->assertEquals($result, 1479672000);
    }

    /**
     * Tests that getTimeStampFromDate returns expected exception when passed incorrect data
     * @expectedException     'TimeStamp conversion failure!'
     */
    public function testFailedGetTimeStampFromDate() {
        date_default_timezone_set('Europe/London');
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = new Carpark($mockPDO, $name);

        $dateTime = '-1 -1';
        $carpark->getTimeStampFromDate($dateTime);
    }

    /**
     * Tests that getConcurrentBookings returns expected bookings given mock values.
     */
    public function testSuccessfulGetConcurrentBookings() {
        date_default_timezone_set('Europe/London');
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = $this->getMockBuilder('Carpark')
            ->setConstructorArgs([$mockPDO, $name])
            ->setMethods(['getRangeTimeStamps', 'incrementTime'])
            ->getMock();

        $start = '2016-12-02 12:00:00';
        $end = '2016-12-02 12:01:00';
        $bookings = [['from' => '2016-12-02 12:00:00', 'to' => '2016-12-02 12:01:00']];
        $timeMeasure = 24;
        $timeIncrement = 60;
        $carpark->method('getRangeTimeStamps')->willReturn(['from' => 1479470400, 'to' => 1479470459]);
        $carpark->method('incrementTime')->willReturn(3456);

        $result = $carpark->getConcurrentBookings($start, $end, $bookings, $timeMeasure, $timeIncrement);
        $this->assertEquals($result, ['2016-12-02 12:00:00' => 1]);
    }

    /**
     * Tests that getConcurrentBookings returns empty array if no bookings exist
     */
    public function testFailedGetConcurrentBookings() {
        date_default_timezone_set('Europe/London');
        $mockPDO = $this->createMock('PDO');
        $mockStatement = $this->createMock('PDOStatement');
        $mockStatement->method('fetch')->willReturn([
            'id' => '1',
            'name' => 'Mr-Carparky',
            'capacity' => 'test_capacity',
            'isVisitor' => 1]);
        $mockPDO->method('prepare')->willReturn($mockStatement);
        $name = 'Mr-Carparky';
        $carpark = $this->getMockBuilder('Carpark')
            ->setConstructorArgs([$mockPDO, $name])
            ->setMethods(['getRangeTimeStamps', 'incrementTime'])
            ->getMock();

        $start = '2016-12-02 12:00:00';
        $end = '2016-12-02';
        $bookings = [['from' => '2016-12-02 12:00:00', 'to' => '2016-12-02 12:01:00']];
        $timeMeasure = 24;
        $timeIncrement = 60;
        $carpark->method('getRangeTimeStamps')->willReturn(['from' => 1479470400, 'to' => 1479470459]);
        $carpark->method('incrementTime')->willReturn(3456);

        $result = $carpark->getConcurrentBookings($start, $end, $bookings, $timeMeasure, $timeIncrement);
        $this->assertEquals($result, []);
    }

//    public function testSuccessfulGetAvailability() {
//        date_default_timezone_set('Europe/London');
//        $mockPDO = $this->createMock('PDO');
//        $mockStatement = $this->createMock('PDOStatement');
//        $mockStatement->method('fetch')->willReturn([
//            'id' => '1',
//            'name' => 'Mr-Carparky',
//            'capacity' => 'test_capacity',
//            'isVisitor' => 1]);
//        $mockStatement->method('fetchAll')->willReturn([
//            ['to' => '2016-12-02 14:00:00',
//            'from' => '2016-12-02 13:00:00'],
//            ['to' => '2016-12-02 13:00:00',
//            'from' => '2016-12-02 12:00:00']
//        ]);
//        $mockPDO->method('prepare')->willReturn($mockStatement);
//        $name = 'Mr-Carparky';
//        $carpark = new Carpark($mockPDO, $name);

//        $carpark = $this->getMockBuilder('Carpark')
//            ->setConstructorArgs([$mockPDO, $name])
//            ->setMethods(['getTimeStampFromTime', 'getTimeStampFromDate', 'getConcurrentBookings'])
//            ->getMock();
//
//        $bookingManager = $this->getMockBuilder('BookingManager')
//            ->setConstructorArgs($mockPDO)
//            ->setMethods('getBookings')
//            ->getMock();
//
//        $result =
//       $this->assertEquals($result, 3);



//    }

//    /**
//     * Calculates quantity of available spaces from carpark capacity and overlapping bookings, using user input
//     * @param $dateTimeFrom STRING date from which user desires to check availability
//     * @param $dateTimeTo STRING date to which user desires to check availability
//     * @param $bookingManager OBJECT containing PDO query for bookings
//     * @return INTEGER number of available spaces
//     */
//    public function getAvailability($dateTimeFrom, $dateTimeTo, $bookingManager) {
//        if ($this->isVisitor) {
//            $startValue = $this->getTimeStampFromTime($dateTimeFrom);
//            $endValue = $this->getTimeStampFromTime($dateTimeTo, 1);
//            $increment = self::MINUTE_INCREMENTS;
//            $measurement = self::MINUTES_IN_HOUR;
//        } else {
//            $dateTimeTo .= self::END_TIME;
//            $dateTimeFrom .= self::START_TIME;
//            $startValue = $this->getTimeStampFromDate($dateTimeFrom);
//            $endValue = $this->getTimeStampFromDate($dateTimeTo);
//            $increment = self::HOURS;
//            $measurement = self::SECONDS_IN_HOUR;
//        }
//        $bookings = $bookingManager->getBookings($this->getId(), $dateTimeFrom, $dateTimeTo);
//        $clashingBookings = $this->getConcurrentBookings($startValue, $endValue, $bookings, $increment,
//            $measurement);
//        return $this->getCapacity() - max($clashingBookings);
//    }

}
