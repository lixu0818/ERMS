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
$status = $_SESSION['status'];

if ($status == 'Available') {
    $repair = "Repair for next <input type='number' name='period'/> days";
    $start_date = date('Y-m-d H:i:s');
} else {
    $repair = "Repair for <input type='number' name='period'/> days after return";
    $start_date = $_SESSION['next_available_date'];
}

if (isset($_POST['submit'])) {
    $period = $_POST['period'];
    if ($period <= 0) {
        header('Refresh:3; url=search_result_repair.php');
        print "<p>Period of repair must be positive!</p>";
        exit();
    }
    $insert_repair_sql = "
            INSERT INTO Repair_Schedule
                (
                    resource_id,
                    start_date,
                    end_date
                )
                VALUES
                (
                    $resource_ID,
                    '$start_date',
                    DATE_ADD('$start_date', INTERVAL $period DAY)
                );
        ";

    $insert_repair_result = mysqli_query($connect, $insert_repair_sql);
    header('Refresh:3; url=profile.php');
    if ($insert_repair_result == true) {
        print "<p>Repair Schedule updated successfully</p>";
    } else {
        print "<p>Error inserting Repair_Schedule record: " . mysqli_errno($connect) . "</p>";
    }
    exit();

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Search Result_Repair Resource</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
<h3>Repair Resources</h3>
<form method="post" action="search_result_repair.php">
    <?php echo $repair; ?>
    <input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>
