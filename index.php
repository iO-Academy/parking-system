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
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/vendor/bootstrap-datepicker.min.js"></script>
    <script src="js/vendor/bootstrap-datepicker.en-GB.min.js"></script>
    <script src="js/availabilityFilter.js"></script>
    <script src="js/vendor/bootstrap.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/bootstrap-datepicker.min.css">
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
        <?php
        if($loggedIn){
            echo '<a class="col-md-1 btn othr-btn" href="account.php">Account</a>';
            echo '<a class="col-md-1 btn log-btn" href="logout.php">Logout</a>';
        }else{
            echo '<a class="col-md-1 btn log-btn" href="login.php">Login</a>';
        }
        ?>
    </div>
</div>
<main>
    <div class="container center-block">
        <div id="filters">
            <div class="col-md-3 person-select form">
                <button class="btn btn-default" id="staffButton" autocomplete="off">Staff</button>
                <button class="btn btn-d  efault" id="visitorButton" autocomplete="off">Visitor</button>
            </div>
            <div class="col-md-7 offset-md-2 date-select form slider" id="staff-container">
                <div id="staffPicker" class="input-group input-daterange">
                    <div class="datepicker pull-left" id="fromCal">From: <span id="fromSpan"></span></div>
                    <div class="datepicker pull-left" id="toCal">To: <span id="toSpan"></span></div>
                </div>
                <input class="btn btn-default" type="submit" value="Submit" id="staffSubmit" disabled>
            </div>
            <div class="col-md-4 offset-md-2 date-select form slider" id="visitor-container">
                <div id="visitorPicker" class="input-group input-daterange">
                    <div class="datepicker pull-left" id="visitorCal">Date: <span id="visitorSpan"></span></div>
                </div>
            </div>
            <div class="col-md-3 date-select slider" id="time-container">
                <div id="timePicker">
                    <div>
                        <h4>From:</h4>
                        <form class="form-inline">
                            <div class="form-group">
                                <select class="form-control timeInput" id="fromHours">
                                    <option disabled selected class="defaultOption">HH</option>
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control timeInput minutes" id="fromMinutes" disabled>
                                    <option disabled selected class="defaultOption">mm</option>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div>
                        <h4>To:</h4>
                        <form class="form-inline">
                            <div class="form-group">
                                <select class="form-control timeInput" id="toHours">
                                    <option disabled selected class="defaultOption">HH</option>
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control timeInput minutes" id="toMinutes" disabled>
                                    <option disabled selected class="defaultOption">mm</option>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div id="fullDayContainer">
                        <label>Full Day</label>
                        <input type="checkbox" id="fullDay">
                    </div>
                    <input class="btn btn-default" type="submit" value="Submit" id="visitorSubmit" disabled>
                </div>
            </div>
        </div>
        <div class="col-md-3" id="alien-container">
            <img id="alien" src="images/alien.svg" alt="alien">
        </div>
        <div class="col-md-6" id="speech-bubble">
            <div class="triangle"></div>
            <div id="availabilityContainer">
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="container center-block">
        <img src="images/logo_mayden.png" alt="mayden">
        <img src="images/logo-academy-solo.png" alt="mayden academy">
        <h4>Icons by IhorZigor from www.shutterstock.com and Freepik from www.flaticon.com</h4>
    </div>
</footer>
</body>
</html>