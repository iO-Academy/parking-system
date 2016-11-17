<?php

require __DIR__ . '/BookingManager.php';

/**
 * Represents a single row of the carpark table.
 * User: benmorris
 * Date: 14/11/2016
 * Time: 14:35
 */
class Carpark
{
    const CARPARK_TABLE_NAME = 'carpark';
    const HOURS = 24;
    const SECONDS_IN_HOUR = 3600;
    const MINUTE_INCREMENTS = 15;
    const MINUTES_IN_HOUR = 60;
    const END_TIME = ' 23:59:59'; //default end of day, formatted for ease of concatenation
    const START_TIME = ' 00:00:00'; //default start of day, formatted for ease of concatenation

    private $pdo;
    private $id;
    private $name;
    private $capacity;
    private $isVisitor;

    /**
     * Carpark constructor.
     * @param PDO $pdo A pdo connected to the project database.
     * @param $name Name of a carpark must match a name in the name column of the `carpark` table.
     * @throws Exception If the $name doesn't exist.
     */
    public function __construct(PDO $pdo, $name) {

        $statement = $pdo->prepare('SELECT * FROM `' . self::CARPARK_TABLE_NAME . '` WHERE `name` = ?;');
        $statement->execute(array($name));
        $result = $statement->fetch();
        if (!empty($result)) {
            $this->pdo = $pdo;
            $this->id = $result['id'];
            $this->name = $name;
            $this->capacity = $result['capacity'];
            $this->isVisitor = $result['isVisitor'];
            return $this;
        } else {
            throw new Exception ('Carpark with name ' . $name . ' does not exist in pdo.');
        }

    }

    /**
     * Getter method for the id column.
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter method for the name column.
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Getter method for the capacity column.
     * @return mixed
     */
    public function getCapacity() {
        return $this->capacity;
    }

    /**
     * Getter method for the isVisitor column.
     * @return mixed
     */
    public function isVisitor() {
        return $this->isVisitor;
    }

    /**
     * Calculates quantity of available spaces from carpark capacity and overlapping bookings, using user input
     * @param $dateTimeFrom STRING date from which user desires to check availability
     * @param $dateTimeTo STRING date to which user desires to check availability
     * @return INTEGER number of available spaces
     */
    public function getAvailability($dateTimeFrom, $dateTimeTo) {
        if ($this->isVisitor) {
            $startValue = $this->getTimeStampFromTime($dateTimeFrom);
            $endValue = $this->getTimeStampFromTime($dateTimeTo, 1);
            $increment = self::MINUTE_INCREMENTS;
            $measurement = self::MINUTES_IN_HOUR;
        } else {
            $dateTimeTo .= self::END_TIME;
            $dateTimeFrom .= self::START_TIME;
            $startValue = $this->getTimeStampFromDate($dateTimeFrom);
            $endValue = $this->getTimeStampFromDate($dateTimeTo);
            $increment = self::HOURS;
            $measurement = self::SECONDS_IN_HOUR;
        }
        $bookingManager = new BookingManager($this->pdo);
        $bookings = $bookingManager->getBookings($this->getId(), $dateTimeFrom, $dateTimeTo);
        $clashingBookings = $this->getConcurrentBookings($startValue, $endValue, $bookings, $increment,
            $measurement);
        return $this->getCapacity() - max($clashingBookings);
    }

    /**
     * @param $start
     * @param $end
     * @param $bookings
     * @param $timeMeasure
     * @param $timeIncrement
     * @return array
     */
    private function getConcurrentBookings($start, $end, $bookings , $timeMeasure, $timeIncrement) {
        $concurrentBookings = [];
        while ($start <= $end) {
            $concurrentBookings[$start] = 0;
            foreach ($bookings as $booking) {
                $dateRange = $this->getRangeTimeStamps($booking);
                if (
                    ($dateRange['from'] <= $start &&
                    $dateRange['to'] > $start) ||
                    ($dateRange['from'] >= $start &&
                    $dateRange['to'] <= $end) ||
                    ($dateRange['from'] > $start &&
                    $dateRange['to'] >= $end)
                ) {
                    $concurrentBookings[$start]++;
                }
            }
            $start = $this->incrementTime($start, $timeMeasure, $timeIncrement);
        }
        return $concurrentBookings;
    }

    /**
     * @param $booking
     * @return array
     */
    private function getRangeTimeStamps($booking) {
        if ($this->isVisitor) {
            $to = $this->getTimeStampFromTime($booking['to'], 1);
            $from = $this->getTimeStampFromTime($booking['from']);
        } else {
            $to = $this->getTimeStampFromDate($booking['to']);
            $from = $this->getTimeStampFromDate($booking['from']);
        }
        $dateRange = ['from' => $from, 'to' => $to];
        return $dateRange;
    }

    /**
     * @param $dateTime
     * @param int $negative
     * @return int
     * @throws Exception
     */
    private function getTimeStampFromTime($dateTime, $negative = 0) {
        $timeStampFromTime = strtotime(explode(' ', $dateTime)[1]) - $negative;
        if(!$timeStampFromTime) {
            throw new Exception('TimeStamp conversion failure!');
        }
        return $timeStampFromTime;
    }

    /**
     * @param $dateTime
     * @return int
     * @throws Exception
     */
    private function getTimeStampFromDate($dateTime) {
        $timeStampFromDate = strtotime($dateTime);
        if(!$timeStampFromDate) {
            throw new Exception('TimeStamp conversion failure!');
        }
        return $timeStampFromDate;
    }

    /**
     * @param $start
     * @param $timeMeasure
     * @param $timeIncrement
     * @return mixed
     */
    private function incrementTime($start, $timeMeasure, $timeIncrement) {
        $start += $timeMeasure * $timeIncrement;
        return $start;
    }

}

