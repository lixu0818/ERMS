<?php
// connect to database
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
?>

<!DOCTYPE html>

<head>
    <title>Resource Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
</head>

<body>

<div id="main_container">

    <div id="header">
        <h2 class="text-center">Resource Status</h2>
    </div>
    <hr>
    <div class="center_content">

                    <table class="table table-hover table-bordered">
                        <h3 class="text-left">Resource in use</h3>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Resource Name</td>
                                <td>Incident</td>
                                <td>Owner</td>
                                <td>Start Date</td>
                                <td>Return by</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <?php
                        $query = "
                            SELECT
                                Resource.id resource_id,
                                Resource.name resource_name,
                                Incident.description,
                                All_user.name owner_name,
                                Deploy_Schedule.start_date,
                                Deploy_Schedule.end_date,
                                Deploy_Schedule.id deploy_schedule_id,
                                Incident.id incident_id 
                            FROM
                                Resource
                                INNER JOIN Request
                                ON Resource.id = Request.requesting_resource_id
                                INNER JOIN Incident
                                ON Request.incident_id = Incident.id
                                INNER JOIN Deploy_Schedule
                                ON (Resource.id = Deploy_Schedule.resource_id AND Incident.id = Deploy_Schedule.responding_incident_id)
                                INNER JOIN
                                (
                                SELECT username, name FROM Municipality
                                UNION
                                SELECT username, name FROM Government_Agency
                                UNION
                                SELECT username, name FROM Company
                                UNION
                                SELECT username, concat(firstname, ' ', lastname) as name FROM Individual
                                ) AS All_user
                                ON Resource.owner_username = All_user.username
                            WHERE
                                Deploy_Schedule.start_date <= sysdate()
                                AND Deploy_Schedule.end_date > sysdate()
                                AND Incident.reporter_username = '$username'
                        ";

                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                            exit();
                        }

                        echo "<form method='post' action='resource_status_action.php'>";

                        while ($row = mysqli_fetch_array($result)) {
                            print "<tr>";
                            print "<td>{$row['resource_id']}</td>";
                            print "<td>{$row['resource_name']}</td>";
                            print "<td>{$row['description']}</td>";
                            print "<td>{$row['owner_name']}</td>";
                            print "<td>{$row['start_date']}</td>";
                            print "<td>{$row['end_date']}</td>";
                            $deploy_schedule_id = $row['deploy_schedule_id'];

                            print "<td>
                                        <input type='submit' name='return[$deploy_schedule_id]' value='Return' /> 
                                   </td>";

                            print "</tr>";
                        }
                        echo "</form>";
                        ?>

                    </table>

                    <table class="table table-hover table-bordered">
                        <h3 class="text-left">Resource Requested by me</h3>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Resource Name</td>
                                <td>Incident</td>
                                <td>Owner</td>
                                <td>Return by</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <?php
                        $query = "
                                    SELECT
                                        Resource.id resource_id,
                                        Resource.name resource_name,
                                        Incident.description,
                                        All_user.name owner_name,
                                        Request.expected_return_date,
                                        Request.id request_id 
                                    FROM
                                        Request
                                        INNER JOIN Resource
                                        ON Request.requesting_resource_id = Resource.id
                                        INNER JOIN Incident
                                        ON Request.incident_id = Incident.id
                                        INNER JOIN
                                        (
                                        SELECT username, name FROM Municipality
                                        UNION
                                        SELECT username, name FROM Government_Agency
                                        UNION
                                        SELECT username, name FROM Company
                                        UNION
                                        SELECT username, concat(firstname, ' ', lastname) as name FROM Individual
                                        ) AS All_user
                                            ON Resource.owner_username = All_user.username
                                    WHERE
                                        Request.sender_username = '$username'
                                        and Request.status = 'Pending'
                                ";

                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                            exit();
                        }

                        echo "<form method='post' action='resource_status_action.php'>";

                        while ($row = mysqli_fetch_array($result)){
                            print "<tr>";
                            print "<td>{$row['resource_id']}</td>";
                            print "<td>{$row['resource_name']}</td>";
                            print "<td>{$row['description']}</td>";
                            print "<td>{$row['owner_name']}</td>";
                            print "<td>{$row['expected_return_date']}</td>";
                            $request_id = $row['request_id'];

                            print "<td>
                                        <input type='submit' name='cancel_request[$request_id]' value='Cancel' /> 
                                   </td>";

                            print "</tr>";
                        }
                        echo "</form>";
                        ?>

                    </table>

                    <table class="table table-hover table-bordered">
                        <h3 class="text-left">Resource Requests received by me</h3>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Resource Name</td>
                                <td>Incident</td>
                                <td>Requested By</td>
                                <td>Return by</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                            <?php
                            $query = "
                                SELECT
                                    Resource.id resource_id,
                                    Resource.name resource_name,
                                    Incident.description,
                                    All_user.name requester_name,
                                    Request.expected_return_date,
                                    Request.id request_id, 
                                    Incident.id incident_id 
                                FROM
                                    Request
                                    INNER JOIN Resource
                                    ON Request.requesting_resource_id = Resource.id
                                    INNER JOIN Incident
                                    ON Request.incident_id = Incident.id
                                    INNER JOIN
                                    (
                                    SELECT username, name FROM Municipality
                                    UNION
                                    SELECT username, name FROM Government_Agency
                                    UNION
                                    SELECT username, name FROM Company
                                    UNION
                                    SELECT username, concat(firstname, ' ', lastname) as name FROM Individual
                                    ) AS All_user
                                    ON Request.sender_username = All_user.username
                                WHERE
                                    Resource.owner_username = '$username'
                                    AND Request.status = 'Pending'
                            ";

                            $result = mysqli_query($connect, $query);

                            if (!$result) {
                                print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                                exit();
                            }

                            echo "<form method='post' action='resource_status_action.php'>";

                            while ($row = mysqli_fetch_array($result)){

                                print "<tr>";
                                print "<td>{$row['resource_id']}</td>";
                                print "<td>{$row['resource_name']}</td>";
                                print "<td>{$row['description']}</td>";
                                print "<td>{$row['requester_name']}</td>";
                                print "<td>{$row['expected_return_date']}</td>";
                                $request_id = $row['request_id'];
                                $incident_id = $row['incident_id'];
                                $resource_id = $row['resource_id'];

                                print "<td>
                                            <input type='submit' name='reject[$request_id]' value='Reject'> 
                                            <input type='submit' name='deploy[$request_id,$incident_id,$resource_id]' value='Deploy' /> 
                                       </td>";

                                print "</tr>";
                            }
                            echo "</form>";
                            ?>

                    </table>

                    <table class="table table-hover table-bordered">
                        <h3 class="text-left">Repair Scheduled/In-progress</h3>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Resource Name</td>
                                <td>Start on</td>
                                <td>Ready by</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <?php
                        $query = "
                                SELECT
                                    Repair_Schedule.resource_id,
                                    Resource.name resource_name,
                                    Repair_Schedule.start_date, 
                                    Repair_Schedule.end_date,
                                    Repair_Schedule.id repair_schedule_id
                                FROM
                                    Repair_Schedule
                                    INNER JOIN Resource
                                    ON Repair_Schedule.resource_id = Resource.id
                                WHERE
                                    Resource.owner_username = '$username'
                                    AND Repair_Schedule.end_date > sysdate() 

                            ";

                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                            exit();
                        }

                        echo "<form method='post' action='resource_status_action.php'>";

                        while ($row = mysqli_fetch_array($result)){
                            print "<tr>";
                            print "<td>{$row['resource_id']}</td>";
                            print "<td>{$row['resource_name']}</td>";
                            print "<td>{$row['start_date']}</td>";
                            print "<td>{$row['end_date']}</td>";

                            $repair_start_date = $row['start_date'];
                            $t1 = strtotime($repair_start_date);
                            $t2 = time();
                            $repair_schedule_id = $row['repair_schedule_id'];

                            if ($t1 > $t2) {
                                print "<td>
                                            <input type='submit' name='cancel_repair[$repair_schedule_id]' value='Cancel' />
                                       </td>";
                            }
                            else{
                                print "<td></td>";
                            }
                            print "</tr>";
                        }
                        echo "</form>";
                        ?>

                    </table>

    </div>
</div>
</br>
<div id="footer">
    <a href="profile.php">Go back to Main Menu</a>
</div>
</body>

</html>
