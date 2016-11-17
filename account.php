<?php
require_once 'autoload.php';

/********** create database **********/

try {
    $db = new DbConnector();
} catch (Exception $e) {
    $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
    header($header_str);
}

$user = new User($db->getDB());

session_start();


/********** validate session data **********/

if (!empty($_SESSION['userAuth'])) {

    try {
        $user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
    } catch (Exception $e) {
        session_destroy();
        $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
        header($header_str);
    }

} elseif (!empty($_POST['email']) && !empty($_POST['password'])) {

    /********** validate / login **********/

    try {
        $user->login($_POST['email'], $_POST['password']);
    } catch (Exception $e) {
        $header_str = 'Location: login.php?success=false&err=' . $e->getMessage();
        header($header_str);
    }
} else {
    header('Location: login.php?success=false');
}

$bookings = $user->getBookings();
$canCreateUser = $user->getCanCreateUser();

///********** handle ajax **********/
////try catch doesnt catch error
//if ($_POST['newEmail']) {
//    try {
//        $user->changeEmail($_POST['newEmail']);
//    } catch(Exception $e) {
//        $err = $e->getMessage();
//    }
//
//
//}
//if ($_POST['newPassword']) {
//    $user->changePassword($_POST['newPassword']);
//}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/account-page.js"></script>
    <title>Space Book</title>
</head>
<body>
<header>
    <div class="container">
        <img class="brand center-block" src="images/spacebook.png" alt="space book">
    </div>
</header>
<div class="logo-bar">
    <div class="container center-block">
        <h1>Account Page</h1>
        <a class="btn othr-btn" href="index.php">Home</a>
        <a class="btn log-btn" href="logout.php">Logout</a>
    </div>
</div>
<main>
    <div class="container center-block">
        <div id="user-details">
            <div id="details" class="user-account-content">
                <h2>User Details</h2>
                <h4 id="email-field">Email: <span><?php echo $_SESSION['email'] ?></span></h4>
                <button type="submit" id="edit" class="btn toggle-user-form">edit</button>
            </div>
            <div id="update-form-container" class="user-account-content">
                <h2>Change Details</h2>
                <form method="post" id="update-form" class="form-horizontal">
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">New Email:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">New Password:</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="submit" id="save-user-details" class="btn" value="Save">
                            <button type="button" class="btn toggle-user-form">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bookings">
            <h2>Your Bookings</h2>
            <?php
            if (is_array($bookings) && count($bookings) > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table"><tr><th>Carpark Name</th><th>Date From</th><th>Time From</th><th>Date To</th><th>Time To</th></tr>';
                foreach ($bookings as $row) {
                    echo "<tr><td>" . $row['Carpark Name'] . "</td>";
                    echo "<td>" . $row['Date From'] . "</td>";
                    echo "<td>" . $row['Time From'] . "</td>";
                    echo "<td>" . $row['Date To'] . "</td>";
                    echo "<td>" . $row['Time To'] . "</td></tr>";
                }
                echo "</table></div>";
            } else {
                echo "<h4>You have no bookings</h4>";
            }
            ?>
        </div>
        <?php
        if ($canCreateUser == 1) {
            echo '<div class="addUser" id = "addUserForm" ><h2>Add New User</h2>
       <form class="form-horizontal">
        <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="password" placeholder="changeMe">
            </div>
        </div>
        <div class="form-group">
            <label for="firstName" class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="firstName" placeholder="John">
            </div>
        </div>
        <div class="form-group">
            <label for="lastName" class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="lastName" placeholder="Smith">
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-2 control-label">Car Make</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="carMake" placeholder="Renault etc.">
            </div>
        </div>
        <div class="form-group">
            <label for="carModel" class="col-sm-2 control-label">Car Model</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="carModel" placeholder="Megane etc.">
            </div>
        </div>
        <div class="form-group">
            <label for="carNumPlate" class="col-sm-2 control-label">Number Plate</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="carNumPlate" placeholder="AB00 ABC">
            </div>
        </div>
        <div class="form-group">
            <label for="phoneNumber" class="col-sm-2 control-label">Telephone</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="phoneNumber" placeholder="01234 567890">
            </div>
        </div>
        <div class="form-group">
            <label for="department" class="col-sm-2 control-label">Department</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="department" placeholder="Finance">
            </div>
        </div>
        <div class="form-group pull-right">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="pull-right btn btn-default">Add User</button>
            </div>
        </div>
    </form>
        </div >';
        }
        ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>