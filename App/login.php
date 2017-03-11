<?php

/* connect to database */

$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");

if (!$connect) {
    die("Failed to connect to database");
}

$errorMsg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username']) or empty($_POST['password'])) {
        $errorMsg = "Please provide both username and password.";
    }
    else {
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);

        $query = "SELECT * FROM User WHERE username = '$username' AND password = '$password'";

        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) == 0) {
            /* login failed */
            $errorMsg = "Login failed.  Please try again.";
        }
        else {
            /* login successful */
            session_start();
            $_SESSION['username'] = $username;

            /* redirect to the profile page */
            header('Location: profile.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Login to ERMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
<div class="container-fluid">
    <div id="main_container">
        <h2 class="text-center"><strong>ERMS</strong></h2>
        <p class = "text-center"><strong>Emergency Resource Management System</strong></p>
    </div>

    <div class="center_content">
        <div class="text_box">
            <form action="login.php" method="post">
                <div class="title"></div>
                <div class="login_form_row text-center">
                    <label class="login_label">Username:</label>
                    <input type="text" name="username" class="login_input" />
                </div>

                <div class="login_form_row text-center">
                    <label class="login_label">Password:</label>
                    <input type="password" name="password" class="login_input" />
                </div>

                <div class="text-center">
                    <input type="submit" name="Submit" value="Login", class="login">
                </div>
                <form/>

                <?php
                if (!empty($errorMsg)) {
                    print "<div class='login_form_row' style='color:red'>$errorMsg</div>";
                }
                ?>
        </div>
    </div>
</div>
</div>
</body>
</html>