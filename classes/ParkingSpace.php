<?php
class ParkingSpace
{
    private $carPark;
    private $user;
    private $fromDateTime;
    private $toDateTime;
    private $conn;

    //DOCBLOCK ME
    public function __constructor($conn) {
        $this->carPark = $_POST['carPark'];
        $this->user = $_SESSION['userId'];
        $this->fromDateTime = $_POST['fromDateTime'];
        $this->toDateTime = $_POST['toDateTime'];
        $this->conn = $conn;
    }

    //DOCBLOCK ME
    public function book() {
        $sql = '
                INSERT INTO `bookings` (`carpark_id`,`from`,`to`,`user_id`)
                VALUES (:carPark,:fromDateTime,:toDateTime,:user)
                ;';
        $ps = $this->conn->prepare($sql);
        $ps->execute([
            ':carPark' => $this->carPark,
            ':fromDateTime' => $this->fromDateTime,
            ':toDateTime' => $this->toDateTime,
            ':user' => $this->user,
        ]);
    }

}

//if ($_POST['carPark'] == 'visitor') {
//    $baseDate = dateConvert($_POST['date']);
//    $fromDateTime = $baseDate . ' ' . $_POST['fromTime'];
//    $toDateTime = $baseDate . ' ' . $_POST['toTime'];
//} else {
//    $fromDateTime = dateConvert($_POST['fromDate']);
//    $toDateTime = dateConvert($_POST['toDate']);
//}