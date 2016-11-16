<?php

// TODO: These need to be removed when this is merged with the autoloader branch
require __DIR__ . '/../classes/DbConnector.php';
require __DIR__ . '/../classes/Carpark.php';
date_default_timezone_set('Europe/London');

$conn = new DbConnector();
$pdo = $conn->getDB();

/**
 * Takes converts a string 'DD/MM/YYYY' to 'YYYY-MM-DD'
 */
function dateConvert($input) {
    return implode('-', array_reverse(explode('/', $input)));
}

// Get the dates in the right format


// Append times if visitors
if ($_POST['carPark'] == 'visitor') {
    $baseDate = dateConvert($_POST['date']);
    $fromDateTime = $baseDate . ' ' . $_POST['fromTime'];
    $toDateTime = $baseDate . ' ' . $_POST['toTime'];
} else {
    $fromDateTime = dateConvert($_POST['fromDate']);
    $toDateTime = dateConvert($_POST['toDate']);
}

$carparks = [];
if ($_POST['carPark'] == 'staff') {
    $carparks[] = new Carpark($pdo, 'hobnob');
    $carparks[] = new Carpark($pdo, 'digestive');
} else {
    $carparks[] = new Carpark($pdo, 'rich tea');
}


$payload = [];
foreach ($carparks as $carpark) {
    try {
        $payload[$carpark->getName()] = $carpark->getAvailability($fromDateTime, $toDateTime);
    } catch (Exception $e) {
        $payload = [];
        break;
    }
}

header('Content-Type: application/json');
echo json_encode($payload);
