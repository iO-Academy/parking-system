<?php
class ParkingSpace
{
    private $carPark;
    private $user;
    private $from;
    private $to;
    private $conn;

    //DOCBLOCK ME
    public function __constructor($conn) {
        $this->carPark = $_POST['carPark'];
        $this->user = $_SESSION['userId'];
        $this->from = $_POST['from'];
        $this->to = $_POST['to'];
        $this->conn = $conn;
    }

    //DOCBLOCK ME
    public function book() {
                $sql = "
                INSERT INTO `bookings` (`carpark_id`,`from`,`to`,`user_id`)
                VALUES (`$this->carPark`,`$this->from`,`$this->to`,`$this->user`)
                ;";

    }

}

// use anonymous placeholders "?" to prevent sql injection

