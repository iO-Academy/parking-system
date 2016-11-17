<?php
require __DIR__ . '/../autoload.php';
date_default_timezone_set('Europe/London');

$conn = new DbConnector();
$pdo = $conn->getDB();

$loggedIn = FALSE;

session_start();
if (!empty($_SESSION['userAuth'])) {
    try {
        $user = new User($pdo);
        $loggedIn = $user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
    } catch (Exception $e) {
        // Not logged in -> Don't do anything
    }
}

// Append times if visitors
if ($_POST['carPark'] == 'visitor') {
    $tmpDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
    $baseDate = $tmpDate->format('Y-m-d');
    $fromDateTime = $baseDate . ' ' . $_POST['fromTime'];
    $toDateTime = $baseDate . ' ' . $_POST['toTime'];
} else {
    $tmpDate = DateTime::createFromFormat('d/m/Y', $_POST['fromDate']);
    $fromDateTime = $tmpDate->format('Y-m-d');

    $tmpDate = DateTime::createFromFormat('d/m/Y', $_POST['toDate']);
    $toDateTime = $tmpDate->format('Y-m-d');
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
        array_push($payload, [
            'carparkId' => $carpark->getId(),
            'carparkName' => $carpark->getName(),
            'availability' => $carpark->getAvailability($fromDateTime, $toDateTime)
        ]);
    } catch (Exception $e) {
        $payload = [];
        break;
    }
}

$payload['loggedIn'] = $loggedIn;

header('Content-Type: application/json');
echo json_encode($payload);