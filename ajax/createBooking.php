<?php
require_once '../autoload.php';

$bookingConnector = new DbConnector();
$conn = $bookingConnector->getDB();
$space = new ParkingSpace($conn);
$space->book(_POST['carParkId'], _POST['fromDateTime'],  _POST['toDateTime'], _SESSION['id']);