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
        $sql = '
                INSERT INTO `bookings` (`carpark_id`,`from`,`to`,`user_id`)
                VALUES (:carPark,:from,:to,:user)
                ;';
        $ps = $this->conn->prepare($sql);
        $ps->execute([
            ':carPark' => $this->carPark,
            ':from' => $this->from,
            ':to' => $this->to,
            ':user' => $this->user,
        ]);
    }

}
