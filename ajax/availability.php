<?php

if ($_POST['carPark'] == 'staff') {
    $staffFromDate = $_POST['fromDate'];
    $staffToDate = $_POST['toDate'];
//    staffQuery($staffFromDate, $staffToDate);
}

if ($_POST['carPark'] == 'visitor') {
    $visitorDate = $_POST['date'];
    $visitorFromTime = $_POST['fromTime'];
    $visitorToTime = $_POST['toTime'];
//    visitorQuery($visitorDate, $visitorFromTime, $visitorToTime);
}

function staffQuery($staffFromDate, $staffToDate) {
//    Run queries
//    echo number of available spaces
}

function visitorQuery($visitorDate, $visitorFromTime, $visitorToTime) {
//    Run queries
//    echo number of available spaces
}

$arr = array(
    'car park 1' => '4',
    'car park 2' => '12'
);

header('Content-Type: application/json');
echo json_encode($arr);

