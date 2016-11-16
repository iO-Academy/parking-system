<?php

/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 16/11/2016
 * Time: 09:15
 */
class Booking
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
        $selectString = 'SELECT `to`, `from` FROM `' . self::TABLE_NAME . '` WHERE `id` = :carparkId AND `to` >= :fromDateTime AND `from` <= :toDateTime';
        $statement = $this->pdo->prepare($selectString);
        $statement->execute([$carparkId, $fromDateTime, $toDateTime]);
        $statement = $pdo->query();
    }

}}