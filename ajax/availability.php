<?php

if ($_POST['carPark'] == 'staff') {
    $staffFromDate = $_POST['fromDate'];
    $staffToDate = $_POST['toDate'];
    var_dump($staffFromDate);
    var_dump($staffToDate);
}

if ($_POST['carPark'] == 'visitor') {
    $visitorDate = $_POST['date'];
    $visitorFromTime = $_POST['fromTime'];
    $visitorToTime = $_POST['toTime'];
}

