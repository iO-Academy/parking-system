<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Space Book</title>
</head>
<header>
    <div class="container">
        <img class="brand center-block" src="images/spacebook.png" alt="space book">
    </div>
</header>
<div class="logo-bar">
    <div class="container center-block">
        <h1>Login Page</h1>
    </div>
</div>
<main>
    <div>
        <div class="col-md-6 col-md-offset-3 well" id="login-form-div">
            <h4>Please Login</h4>
            <?php
            if($_GET['err']) {
                echo '<div class="text-danger">*' . $_GET['err'] . '</div>';
            }
            ?>
            <hr>
            <form method="POST" action="account.php" id="loginForm" class="form-horizontal">
                <div class="form-group">
                    <label for="usr" class="col-md-3 control-label">Email:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pwd" class="col-md-3 control-label">Password:</label>
                    <div  class="col-md-9">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <input type="submit" class="btn btn-default sign-in" value="Sign in">
                        <button type="button" class="btn btn-default pull-right disabled forgotten-password">Forgotten Password?</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<footer>
</footer>
</body>
</html>



