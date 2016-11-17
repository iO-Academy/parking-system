<?php
require_once "../autoload.php";
function userDataFilter ($key) {
    $userTableColumnNames = array('email','password','validationString','firstName','lastName',
        'carMake','carModel','carNumPlate', 'phoneNumber', 'department');
    return in_array($key, $userTableColumnNames);
}

$userData = array_filter($_POST, 'userDataFilter', ARRAY_FILTER_USE_KEY);

$conn = new DbConnector();
$user = new User($conn->getDB());
return $user->addUser($userData);