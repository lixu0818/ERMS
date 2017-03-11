<?php
/* connect to database */
$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");
if (!$connect) {
    die("Failed to connect to database");}

//Onclick methods for buttons
if (isset($_POST['cancel'])) {
    header('Location: profile.php');
    exit();
}

$errorMsg = "";
if(isset($_POST['submit'])) {

    if (empty($_POST['date']) or empty($_POST['description']) or empty($_POST['lat']) or empty($_POST['lon'])) {
        $errorMsg = "<div class='text-center' style='color:red'><BR>Please enter date, description and location. </div>";
    }

    else{
        $incident_date = mysqli_real_escape_string($connect, $_POST['date']);
        $description = mysqli_real_escape_string($connect, $_POST['description']);

        $lat = (float)$_POST['lat'];
        $lon = (float)$_POST['lon'];
        session_start();
        $username = $_SESSION['username'];

        $query = "       
                INSERT INTO Incident
                (
                    reporter_username,
                    incident_date,
                    description,
                    lat,            
                    lon        
                    )
                VALUES
                (
                    '$username', 
                    STR_TO_DATE('$incident_date', '%Y-%m-%d'), 
                    '$description', 
                    $lat, 
                    $lon)
                  ";

        $result = mysqli_query($connect, $query);
        if (!$result) {
            $errorMsg = "Insertion failed.  Please try again.";
        }

        else {
            echo "<BR><p><b>New incident added successfully</b></p>";
            header('Refresh:3; url=profile.php');
            exit();
        }
    }
}?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Incident Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <meta charset="utf-8">
</head>
<body>

<div id="main_container">
    <h2 class="text-center"><strong>New Incident Info</strong></h2>
    <hr>
    <form action="add_incident.php" method="post">
        <div class=" text-center">
            <label>Date       </label>
            <input type="date" name="date" class="add_incident_input" />

        </div>

        <div class=" text-center">
            <label>Description</label>
            <input type="text" name="description" class="add_incident_input" />
        </div>
        <div class=" text-center">
            <label>Location   </label>

            <label>Lat        </label>
            <input type="number" step = "0.001" max = "90" min = "-90" name="lat" class="add_incident_input" />

            <label>Lon        </label>
            <input type="number" step = "0.001" max = "180" min = "-180" name="lon" class="add_incident_input" />
        </div>

        <div class="text-center">
            <input type="submit" name="submit" value="Save">
            <input type="submit" name="cancel" value="Cancel">
            <input type="reset" name="reset" value="Reset">
        </div>
        <form/>

        <?php
        if (!empty($errorMsg)) {
            print "<style='color:red'>$errorMsg</div>";
        }
        ?>
</div>
</body>
