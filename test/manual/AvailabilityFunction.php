<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 16/11/2016
 * Time: 09:47
 */

include '/Users/benmorris/Documents/Development/academy/parking-system/classes/BookingManager.php';
include '/Users/benmorris/Documents/Development/academy/parking-system/classes/Carpark.php';

$servername = "192.168.20.56";
$dbname = "academy";
$username = "root";
$password = "";
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$carpark = new Carpark($pdo, 'magic');
$bookingManager = new BookingManager($pdo);
$bookings = $bookingManager->getBookings($carpark->getId(), '2016-11-20', '2016-11-22');
var_dump($carpark->getId());
var_dump($bookings);