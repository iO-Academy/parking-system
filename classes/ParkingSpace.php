<?php
class ParkingSpace
{
    private $conn;

    /**
     * Sets $conn property to passed in PDO
     *
     * @param $conn OBJECT PDO
     */
    public function __constructor($conn) {
        $this->conn = $conn;
    }

    /*DOCBLOCK ME I'm aware that there is an inconsistency with the naming convention, in that there are underscores
    and camelCase. Both have been used in the project, as we failed to set a convention at the beginning, and this
    just happens to be a point where the two naming conventions meet up. Aside: carpark_id is poor naming as carpark
    should be two words.
    */
    public function book($carParkId, $fromDateTime, $toDateTime, $userId) {
        $sql = '
                INSERT INTO `bookings` (`carpark_id`,`from`,`to`,`user_id`)
                VALUES (:carParkId,:fromDateTime,:toDateTime,:userId) 
                ;';
        $ps = $this->conn->prepare($sql);
        $ps->execute([
            ':carParkId' => $carParkId,
            ':fromDateTime' => $fromDateTime,
            ':toDateTime' => $toDateTime,
            ':userId' => $userId, 
        ]);
    }

}