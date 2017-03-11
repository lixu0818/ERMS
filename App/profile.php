<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <meta charset="utf-8">
</head>

<div id="main_container">
    <h2 class="text-center"><strong>ERMS</strong></h2>
    <p class = "text-center"><strong>Main Menu</strong></p>

</div>


<?php
$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");
if (!$connect) {
    die("Failed to connect to database");
}

session_start();

if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: login.php');
    exit();
}

$usertype_query = "SELECT type FROM User WHERE username = '$username'";

$result = mysqli_query($connect, $usertype_query); // $result is an dict, e.g. {'type':'Individual'}
if (!$result) {
    print "<p class='error'>Error: " . mysqli_error() . "</p>";
    exit();
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
    print "<p>Error: No data returned from database. </p>";
    exit();
}

$usertype = $row['type'];

if ($usertype == 'Individual') {
    $user_query = "
        SELECT
            CONCAT_WS (' ', Individual.firstname, Individual.lastname) AS name,
            Individual.job_title,
            Individual.hired_date
        FROM
            Individual
        WHERE
            Individual.username = '$username'
    ";
    $user_data = mysqli_query($connect, $user_query);
    $user_row = mysqli_fetch_assoc($user_data);
    $_SESSION['user_name']= $user_row['name'];
    echo "<p class=\"text-center\">${user_row['name']}</p>";
    echo "<p class=\"text-center\">Job Title: ${user_row['job_title']}</p>";
    echo "<p class=\"text-center\">Hired Date: ${user_row['hired_date']}</p>";
}

if ($usertype == 'Company'){
    $user_query = "
            SELECT
                Company.name,
                Company.headquarter_location
            FROM
                Company
            WHERE
                Company.username = '$username'
        ";
    $user_data = mysqli_query($connect, $user_query);
    $user_row = mysqli_fetch_assoc($user_data);
    $_SESSION['user_name']= $user_row['name'];
    echo "<p class=\"text-center\">${user_row['name']}</p>";
    echo "<p class=\"text-center\">Headquarter Location: ${user_row['headquarter_location']}</p>";

}


if ($usertype == 'Government_Agency'){
    $user_query = "
            SELECT
                Government_Agency.name,
                Government_Agency.jurisdiction
            FROM
                Government_Agency
            WHERE
                Government_Agency.username = '$username'
        ";
    $user_data = mysqli_query($connect, $user_query);
    $user_row = mysqli_fetch_assoc($user_data);
    $_SESSION['user_name']= $user_row['name'];
    echo "<p class=\"text-center\">${user_row['name']}</p>";
    echo "<p class=\"text-center\">Jurisdiction: ${user_row['jurisdiction']}</p>";
}

if ($usertype == 'Municipality'){
    $user_query = "
            SELECT
                Municipality.name,
                Municipality.population_size
            FROM
                Municipality
            WHERE
                Municipality.username = '$username'
        ";
    $user_data = mysqli_query($connect, $user_query);
    $user_row = mysqli_fetch_assoc($user_data);
    $_SESSION['user_name']= $user_row['name'];
    echo "<p class=\"text-center\">${user_row['name']}</p>";
    echo "<p class=\"text-center\">Population Size: ${user_row['population_size']}</p>";

}

?>

<body>
<div id="header">
</div>
<hr/>
<div class="menu text-center">

        <p><a href="add_incident.php">Report New Incident</a></p>
        <p><a href="add_resource.php">Add New Resource</a></p>
        <p><a href="search_resource.php">Search Resource</a></p>
        <p><a href="resource_status.php">Resource Status</a></p>
        <p><a href="resource_report.php">Resource Report</a></p>
        <p><a href="update_resource.php">Edit My Resources</a></p>
        <p><a href="login.php">Exit</a></p>

</div>
</body>
</html>
