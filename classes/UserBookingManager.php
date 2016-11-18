<?php

class UserBookingManager extends BookingManager
{
    const TABLE_NAME = 'bookings';

    private $pdo;
    private $userId;

    public function __construct(PDO $pdo, $userId) {
    $this->pdo = $pdo;
        $this->userId = $userId;
    }

    /**
     * @param $fromDateTime
     * @param $toDateTime
     */
    public function getBookings($carparkId, $fromDateTime, $toDateTime) {
        $selectString = 'SELECT `to`, `from` FROM `' . self::TABLE_NAME . '` WHERE `carpark_id` = ? AND `to` >= ? AND `from` <= ? AND `user_id` = ?;';
        $statement = $this->pdo->prepare($selectString);
        $statement->execute([$carparkId, $fromDateTime, $toDateTime, $this->userId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}