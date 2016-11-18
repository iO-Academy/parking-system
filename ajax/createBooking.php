<?php
require_once '../autoload.php';

try {
    $bookingConnector = new DbConnector();
    $conn = $bookingConnector->getDB();
    $space = new ParkingSpace($conn);
    session_start();
    $result = $space->book($_POST['carParkId'], $_POST['fromDateTime'],  $_POST['toDateTime'], $_SESSION['id']);
    $array = ['result' => $result];
} catch (Exception $e) {
    $array = ['result' => FALSE];
}

header('Content-Type: application/json');
echo json_encode($array);