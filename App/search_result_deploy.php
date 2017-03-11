<?php
/**
 * Created by PhpStorm.
 * User: Peng
 * Date: 2016/11/14
 * Time: 5:03
 */
$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");
if (!$connect) {
    die("Failed to connect to database");
}
session_start();

$resource_ID = $_SESSION['resource_id'];
$incident_id = $_SESSION['incident'];
$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $period = $_POST['period'];
    if ($period <= 0) {
        header('Refresh:3; url=search_result_deploy.php');
        print "<p>Period of use must be positive!</p>";
        exit();
    }
    $insert_deploy_sql = "
            INSERT INTO Deploy_Schedule
                (
                    resource_id,
                    responding_incident_id,
                    start_date,
                    end_date
                )
                VALUES
                (
                    $resource_ID,
                    $incident_id,
                    sysdate(),
                    DATE_ADD(sysdate(), INTERVAL $period DAY)
                );
        ";

    $insert_deploy_result = mysqli_query($connect, $insert_deploy_sql);

    # check if we need to record a self-request
    $owner_sql = "select owner_username from Resource where id =  $resource_ID";
    $owner_data = mysqli_query($connect, $owner_sql);
    $owner_row = mysqli_fetch_assoc($owner_data);
    $owner_username = $owner_row['owner_username'];
    if ($owner_username == $username) {
        $insert_self_request_sql = "
            INSERT INTO Request
                (
                    status,
                    expected_return_date,
                    requesting_resource_id,
                    sender_username,
                    incident_id
                )
                VALUES
                (
                    'Accepted',
                    DATE_ADD(sysdate(), INTERVAL $period DAY),
                    $resource_ID,
                    '$username',
                    $incident_id
                );
        ";
        $insert_self_request_result = mysqli_query($connect, $insert_self_request_sql);
    }


    if ($insert_deploy_result == true) {
        echo "<p>Deploy Schedule updated successfully</p>";
    } else {
        echo "<p>Error inserting Deploy_Schedule record: " . mysqli_errno($connect) . "</p>";
    }

    header('Refresh:3; url=profile.php');
    exit();

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Search Result_Deploy Resource</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <h3>Deploy Resources</h3>
    <form method="post" action="search_result_deploy.php">
        Deploy for <input type="number" name="period"/> days
        <input type="submit" name="submit" value="Submit" />
    </form>

</body>
</html>
