<?php
require_once 'autoload.php';

$loggedIn = FALSE;

/********** create database **********/

try{
    $db = new DbConnector();
} catch(Exception $e) {
    $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
    header($header_str);
}

$user = new User($db->getDB());

session_start();


/********** validate session data **********/

if(!empty($_SESSION['userAuth'])) {

    try {
        $loggedIn = $user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
    } catch(Exception $e) {
        session_destroy();
        $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
        header($header_str);
    }

}
//add this else statement to stop users from seeing home if they're not logged in
/*
else {
    header('Location: login.php?success=false');
}
*/

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Space Book</title>
</head>
<body>
    <header>
        <div class="container">
            <img class="brand center-block" src="images/spacebook.png" alt="space book">
        </div>
    </header>
    <div class="logo-bar home">
        <div class="container center-block">
            <img src="images/header.png" alt="Space Book rocket logo">
            <a class="col-md-1 btn othr-btn" href="account.php">Account</a>
            <?php
            if($loggedIn){
                echo '<a class="col-md-1 btn log-btn" href="logout.php">Logout</a>';
            }else{
                echo '<a class="col-md-1 btn log-btn" href="login.php">Login</a>';
            }
            ?>
        </div>
    </div>
    <main>
        <div class="container center-block">
            <div class="col-md-3 person-select form">
                <a class="btn" href="#">
                    <h2>Staff</h2>
                </a>
                <a class="btn" href="#">
                    <h2>Visitor</h2>
                </a>
            </div>
            <div class="col-md-5 date-select form btn"></div>
            <div class="col-md-3 time-select form btn"></div>
            <img src="#" alt="#">
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>