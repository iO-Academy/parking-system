<?php

/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 16/11/2016
 * Time: 09:15
 */
class BookingManager
{
    const TABLE_NAME = 'bookings';

    private $pdo;

    public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
    }

    /**
     * @param $fromDateTime
     * @param $toDateTime
     */
    public function getBookings($carparkId, $fromDateTime, $toDateTime) {
        $selectString = 'SELECT `to`, `from` FROM `' . self::TABLE_NAME . '` WHERE `id` = ? AND `to` >= ? AND `from` <= ?';
        $statement = $this->pdo->prepare($selectString);
        $statement->execute([$carparkId, $fromDateTime, $toDateTime]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}