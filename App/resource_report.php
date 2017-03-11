<?php
// connect to database
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

//$timezone = date_default_timezone_get();
//print "<p>The current server timezone is: " . $timezone . "</p>";
//$now = date('Y-m-d h:i:s', time());
//echo "<p>Report Date: $now</p>";
//echo "<p>Report for: $username</p>";
?>

<!DOCTYPE html>

<head xmlns="http://www.w3.org/1999/html">
    <title>Resource Report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
</head>

<body>

<div id="container">

    <div id="header">
        <h2 class="text-left">Resource Report by Primary Emergency Support Function</h2>
    </div>

    <div class="center_content">
        <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Primary Emergency Support Function</td>
                                <td>Total Resources</td>
                                <td>Resources in Use</td>
                            </tr>
                        </thead>
                        <?php
                        $query = "
                            SELECT
                                ESF.id,
                                ESF.description,
                                IFNULL(r1.total_resources, 0) total_resources,
                                IFNULL(r2.resources_in_use, 0) resources_in_use
                            FROM
                                ESF
                                LEFT JOIN
                                (
                                    SELECT
                                        Resource.primary_ESF_id,
                                        count(Resource.id) total_resources
                                    FROM
                                        Resource
                                    WHERE
                                        Resource.owner_username = '$username'
                                    GROUP BY
                                        Resource.primary_ESF_id
                                ) r1
                                ON ESF.id = r1.primary_ESF_id
                                LEFT JOIN
                                (
                                    SELECT
                                        Resource.primary_ESF_id,
                                        count(Resource.id) resources_in_use
                                    FROM
                                        Resource
                                        INNER JOIN Deploy_Schedule
                                        ON Resource.id = Deploy_Schedule.resource_id
                                    WHERE
                                        Resource.owner_username = '$username'
                                        AND Deploy_Schedule.start_date <= sysdate()
                                        AND Deploy_Schedule.end_date > sysdate()
                                    GROUP BY
                                        primary_ESF_id
                                ) r2
                                ON ESF.id = r2.primary_ESF_id
                            ORDER BY
                                ESF.id
                        ";

                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                            exit();
                        }

                        $sum_total_resources = 0;
                        $sum_resources_in_use = 0;

                        print "<tbody>";
                        while ($row = mysqli_fetch_array($result)){
                            print "<tr>";
                            print "<td>{$row['id']} </td>";
                            print "<td>{$row['description']}</td>";
                            print "<td>{$row['total_resources']}</td>";
                            print "<td>{$row['resources_in_use']}</td>";
                            print "</tr>";
                            $sum_total_resources = $sum_total_resources + $row['total_resources'];
                            $sum_resources_in_use = $sum_resources_in_use + $row['resources_in_use'];
                        }

                        print "<tr>";
                            print "<td></td>";
                            print "<td><b>TOTALS</b></td>";
                            print "<td><b>$sum_total_resources</b></td>";
                            print "<td><b>$sum_resources_in_use</b></td>";
                        print "</tr>";
                        print "</tbody>";
                        ?>

                    </table>
    </div>
</div>
</br></br>
<div id="footer">

    <a href="profile.php">Go back to Main Menu</a>

</div>


</body>

</html>
