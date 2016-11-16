<?php

//function d ($var) {
//    die(var_dump($var));
//}

/**
 * Represents a single row of the carpark table.
 * User: benmorris
 * Date: 14/11/2016
 * Time: 14:35
 */
class Carpark
{
    const CARPARK_TABLE_NAME = 'carpark';

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
     * Returns number of available spaces for user specified dates/times.
     * @param $dateTimeFrom STRING the date/date from which the user desires to check space availability. Format:
     * 'YYYY-MM-DD HH:MM'.
     * @param $dateTimeTo STRING the date/time to which the user desires to check space availability. Format: 'YYYY-MM-DD
     * HH:MM'.
     * @return INTEGER number of available spaces.
     * @throws Exception
     */
    public function getAvailability($dateTimeFrom, $dateTimeTo) {
        $bookingManager = new BookingManager($this->pdo);
        //gets bookings from database
        $bookings = $bookingManager->getBookings($this->getId(), $dateTimeFrom, $dateTimeTo);

        // Handling datetime case
        if ($this->isVisitor()) {
            // Test that the input was provided in correct format for carpark type
            if (count(explode(' ', $dateTimeFrom)) < 2) {
                throw new Exception('Availability in days for visitor!');
            }
            //Splits on space due to parameter format and converts to Unix time stamp
            $startTime = strtotime(explode(' ', $dateTimeFrom)[1]);
            $endTime = strtotime(explode(' ', $dateTimeTo)[1]);
            $time = $startTime;
            $bookingsAtTime = [];
            //iterates through each booking, checking if times clash with user specified times
            while ($time < $endTime) {
                $bookingsAtTime[$time] = 0;
                foreach ($bookings as $booking) {
                    if (strtotime(explode(' ', $booking['from'])[1]) <= $time && $time < strtotime(explode(' ',
                            $booking['to'])[1])) {
                        $bookingsAtTime[$time]++;
                    }
                }

            $time += 15 * 60;
            }
            //returns maximum number of bookings subtracted from carpark capacity
            return  $this->getCapacity() - max($bookingsAtTime);
        } else {
            // Test that the input was provided in correct format for carpark type
            if (count(explode(' ', $dateTimeFrom)) > 1) {
                throw new Exception('Availability in hours for staff!');
            }
            //Splits on space, due to parameter format
            $startDay = explode(' ', $dateTimeFrom)[0];
            $endDay = explode(' ', $dateTimeTo)[0];
            $day = $startDay;
            $bookingsOnDay = [];
            //iterates through each booking, checking if dates clash with user specified dates
            while ($day <= $endDay) {
                $bookingsOnDay[$day] = 0;
                foreach ($bookings as $booking) {
                    if (self::check_in_range(explode(' ', $booking['from'])[0], explode(' ', $booking['to'])[0], $day)) {
                        $bookingsOnDay[$day]++;
                    }
                }
                //converts to Unix time stamp in order to increment date
                $date = strtotime("+1 day", strtotime($day));
                $day = date("Y-m-d", $date);
            }
            //returns maximum number of bookings subtracted from carpark capacity
            return  $this->getCapacity() - max($bookingsOnDay);
        }
    }

    /**
     * Returns a boolean, equating to whether user date is between start and end date
     * @param $start_date STRING start date of booking
     * @param $end_date STRING end date of booking
     * @param $date_from_user STRING date to check against start and end date of booking
     * @return bool
     */
    public static function check_in_range($start_date, $end_date, $date_from_user) {

        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }



}