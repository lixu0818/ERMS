<?php
/**
 * Created by PhpStorm.
 * User: Peng
 * Date: 2016/11/4
 * Time: 22:30
 */
/* connect to database */

$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");

if (!$connect) {
    die("Failed to connect to database");
}

session_start();

if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
else {
    header('Location: login.php');
    exit();
}
//Show drop-down list of ESFs
$query1 = "SELECT * FROM ESF";
$esfs = mysqli_query($connect, $query1);
$esf_options = "<option value=-1 selected></option>";
while ($esf = mysqli_fetch_array($esfs)) {
    $esf_options = $esf_options."<option value=$esf[0]>(#$esf[0]) $esf[1]</option>";
}

//Show drop-down list of private incidents
$query2 = "SELECT ID, description FROM Incident WHERE reporter_username='$username'";
$incidents = mysqli_query($connect, $query2);

$incident_options = "<option value=-1 selected></option>";
while ($incident = mysqli_fetch_array($incidents)) {
    $incident_options = $incident_options."<option value=$incident[0]>($incident[0]) $incident[1]</option>";
}

//Onclick methods for buttons
if (isset($_POST['cancel'])) {
    /* redirect to the main menu page */
    header('Location: profile.php');
    exit();
}

if(isset($_POST['submit'])) {
    if (!empty($_POST['keyword'])) {
        $_SESSION['keyword'] = mysqli_real_escape_string($connect, $_POST['keyword']);;
    } else {
        $_SESSION['keyword'] = '';
    }
    if (isset($_POST['esf_id'])) {
        $_SESSION['esf_id'] = $_POST['esf_id'];
    } else {
        $_SESSION['esf_id'] = -1;
    }
    if (!empty($_POST['distance'])) {
        $_SESSION['distance'] = $_POST['distance'];
    } else {
        $_SESSION['distance'] = PHP_INT_MAX;
    }
    if (isset($_SESSION['incident'])) {
        $_SESSION['incident'] = $_POST['incident'];
    } else {
        $_SESSION['incident'] = -1;
    }

    /* redirect to the search result page */
    header('Location: search_result.php');
    exit();
}


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Search Resources</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <meta charset="utf-8">
</head>

<body>
    <h3 class="text-center">Search Resource</h3>
    <hr>
    <div id="main_container">
    <form action="search_resource.php" method="post" class="text-center">
        <p>
            <label for="keyword">Keyword:</label>
            <input id="keyword" type="text" name="keyword"/><br />
        </p>
        <p></p>
        <p>
            <label for="esf_id">ESF:</label>
            <select name="esf_id">
                <?php echo $esf_options; ?>
            </select>
            <br />
        </p>
        <p></p>
        <p>
            <label for="distance">Location:</label>
            Within<input id="distance" type="text" size="4em" name="distance"/> Kilometers of incident<br />
        <p/>
        <p></p>
        <p>
            <label for="incident">Incident:</label>
            <select name="incident">
                <?php echo $incident_options; ?>
            </select>
            <br />
        </p>
        <p></p>

        <div class="buttons">
            <input type="submit" name="cancel" value="Cancel" />
            <input type="submit" name="submit" value="Submit" />
        </div>

    </form>
    </div>
</body>
</html>
