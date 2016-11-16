<?php

if ($_POST['carPark'] == 'staff') {
    $staffFromDate = $_POST['fromDate'];
    $staffToDate = $_POST['toDate'];
}

if ($_POST['carPark'] == 'visitor') {
    $visitorDate = $_POST['date'];
    $visitorFromTime = $_POST['fromTime'];
    $visitorToTime = $_POST['toTime'];
}

