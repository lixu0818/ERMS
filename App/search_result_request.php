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
$incident_ID = $_SESSION['incident'];
$username = $_SESSION['username'];


if (isset($_POST['submit'])) {
    $return = mysqli_real_escape_string($connect, $_POST['return_date']);
    $return_date = date('Y-m-d H:i:s', strtotime($return));

    if ($return_date <= date('Y-m-d H:i:s')) {
        header('Refresh:3; url=search_result_request.php');
        print "<p>You can not return in the past!</p>";
        exit();
    }

    $insert_request_sql = "
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
                    'Pending',
                    '$return_date',
                    $resource_ID,
                    '$username',
                    $incident_ID
                );
        ";

    $insert_request_result = mysqli_query($connect, $insert_request_sql);
    header('Refresh:3; url=profile.php');

    if ($insert_request_result == true) {
        echo "<p>Request updated successfully</p>";
    } else {
        echo "<p>Error inserting Request record: " . mysqli_errno($connect) . "</p>";
    }
    exit();

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Search Result_Request Resource</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
<h3>Request Resources</h3>
<form method="post" action="search_result_request.php">
    Expect return date(YYYY-MM-DD): <input type="text" name="return_date"/>
    <input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>
