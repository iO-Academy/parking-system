<?php
require 'autoload.php';

session_start();

try {
    $db = new DbConnector();
} catch (Exception $e) {
    $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
    header($header_str);
}

$user = new User($db->getDB());

/********** validate session data **********/

    try {
        $user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
    } catch (Exception $e) {
        session_destroy();
        $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
        header($header_str);
    }

/********** handle ajax **********/
//try catch doesnt catch error
if ($_POST['newEmail']) {
    try {
        $user->changeEmail($_POST['newEmail']);
    } catch(Exception $e) {
        echo $e->getMessage();
    }


}
if ($_POST['newPassword']) {
    $user->changePassword($_POST['newPassword']);
}