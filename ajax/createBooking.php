<?php
require_once "../autoload.php";

$bookingConnector = new DbConnector();
$conn = $bookingConnector->getDB();
$space = new ParkingSpace($conn);
$space->book();