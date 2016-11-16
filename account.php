<?php
session_start();
if(!empty($_SESSION['userAuth'])) {
    //validate user auth
} elseif(!empty($_POST['email']) && !empty($_POST['password'])) {
     //logged them in

    include 'classes/DbConnector.php';
    include 'classes/User.php';



    try{
        $db = new DbConnector();
    } catch(Exception $e) {
        //display error message in html
        echo $e->getMessage();
    }

    $user = new User($db->getDB());
    try{
        $user->login($_POST['email'], $_POST['password']);
    } catch(Exception $e) {
        //display error message in html
        header('Location: login.html?success=false');echo $e->getMessage();

    }

    //set session to logged in and email
    //random string using time





//    echo "<p>HI</p>";
} else {
    header('Location: login.html?success=false');
}


?>



<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="js/jquery-1.12.4.min.js"></script>
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
        <a class="btn" href="#">Logout</a>
    </div>
</div>
<main>
    <div class="container center-block">
        <div id="user-details">
            <div id="details" class="user-account-content">
                <h2>User Details</h2>
                <h4 id="email-field">Email: <span>example@email.com</span></h4>
                <h4>Password: password1</h4>
                <button type="submit" id="edit" class="btn">edit</button>
            </div>
            <div id="update-form" class="user-account-content">
                <h2>Change Details</h2>
                <form method="post" class="form-horizontal">
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">New Email:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">New Password:</label>
                        <div  class="col-md-6">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="submit" id="save-user-details" class="btn" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bookings">
            <h2>Your Bookings</h2>
            <h4>You have no bookings</h4>
        </div>
    </div>
</main>
<footer>
</footer>
</body>
</html>