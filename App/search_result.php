<?php
/**
 * Created by PhpStorm.
 * User: Peng
 * Date: 2016/11/6
 * Time: 20:06
 */
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

    $incident_ID = $_SESSION['incident'];
    $keyword = $_SESSION['keyword'];
    $esf_id = $_SESSION['esf_id'];
    $distance = $_SESSION['distance'];

    if(isset($_POST['deploy'])) {
        foreach($_POST['deploy'] as $key => $value) {
            $_SESSION['resource_id'] = $key;
            header('Location: search_result_deploy.php');
            exit();
        }

    }

    if(isset($_POST['repair'])) {
        foreach($_POST['repair'] as $key => $value) {
            $keyArray = explode(',', $key);
            $_SESSION['resource_id'] = $keyArray[0];
            $_SESSION['status'] = $keyArray[1];
            $_SESSION['next_available_date'] = $keyArray[2];
            header('Location: search_result_repair.php');
            exit();
        }
    }

    if(isset($_POST['request'])) {
        foreach($_POST['request'] as $key => $value) {
            $_SESSION['resource_id'] = $key;
            header('Location: search_result_request.php');
            exit();
        }
    }

    if(isset($_POST['close'])) {
        header('Location: profile.php');
        exit();
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Search Result</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <div id="container">
        <?php
            if ($incident_ID != -1) {
                $query = "SELECT ID, description,lat,lon FROM Incident WHERE ID=$incident_ID";
                $incident = mysqli_fetch_array(mysqli_query($connect, $query));
                echo "<h2>Search Results for Incident:</h2>";
                echo "<h2>{$incident['description']}({$incident['ID']})</h2>";
            } else {
                echo "<h2>Search Results</h2>";
            }

        ?>

        <table class="table table-hover table-bordered">

            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Owner</td>
                    <td>Cost</td>
                    <td>Status</td>
                    <td>Next Available</td>
                    <td>Distance (km)</td>
                    <td>Action</td>
                </tr>
            </thead>
            <?php
                $base_query = "SELECT DISTINCT 
                                    Resource.id,
                                    Resource.name,
                                    Resource.owner_username,
                                    Resource.lat,
                                    Resource.lon,
                                    concat('$', Resource.cost_dollar_amount,'/',Resource.cost_denominator) AS cost,
                                    IFNULL(repair_or_deploy.status, 'Available') AS status,
                                    IFNULL(repair_or_deploy.end_date, sysdate()) AS next_available_date
                                FROM
                                    Resource 
                                    LEFT JOIN
                                    (
                                        SELECT
                                            resource_id,
                                            'In Repair' status,
                                            end_date
                                        FROM
                                            Repair_Schedule
                                        WHERE
                                            start_date <= sysdate()
                                            AND end_date > sysdate()
                                        UNION
                                        SELECT
                                            resource_id,
                                            'In Use' status,
                                            end_date
                                        FROM
                                            Deploy_Schedule
                                        WHERE
                                            start_date <= sysdate()
                                            AND end_date > sysdate()
                                    ) repair_or_deploy
                                    ON Resource.id = repair_or_deploy.resource_id
                                   ";

                if ($keyword != '' and $esf_id != -1) {
                    $base_query = $base_query."
                        LEFT JOIN Capability
                        ON Resource.id = Capability.resource_id
                        LEFT JOIN Resource_AdditionalESF
                        ON Resource.id = Resource_AdditionalESF.resource_id
                    WHERE
                        (Resource.name LIKE '%$keyword%'
                                        OR Resource.model LIKE '%$keyword%'
                                        OR Capability.capability LIKE '%$keyword%')
                        AND
                        (Resource.primary_ESF_id = $esf_id
                            OR Resource_AdditionalESF.ESF_id = $esf_id)
                    ";
                } elseif ($keyword != '') {
                    $base_query = $base_query."
                        LEFT JOIN Capability
                        ON Resource.id = Capability.resource_id
                    WHERE
                        Resource.name LIKE '%$keyword%'
                        OR Resource.model LIKE '%$keyword%'
                        OR Capability.capability LIKE '%$keyword%'
                    ";
                } elseif ($esf_id != -1) {
                    $base_query = $base_query."
                        LEFT JOIN Resource_AdditionalESF
                        ON Resource.id = Resource_AdditionalESF.resource_id
                    WHERE
                        Resource.primary_ESF_id = $esf_id
                        OR Resource_AdditionalESF.ESF_id = $esf_id
                    ";
                }

                $base_query = $base_query."ORDER BY next_available_date ASC, Resource.name ASC";

                if ($incident_ID != -1) {
                    $distance_sql = "
                        @lat1 := RADIANS(Resource.lat),
                        @lon1 := RADIANS(Resource.lon),
                        @lat2 := RADIANS($incident[2]),
                        @lon2 := RADIANS($incident[3]),
                        @delta_lat := (@lat2 - @lat1),
                        @delta_lon := (@lon2 - @lon1),
                        @a := POWER(SIN(@delta_lat/2), 2) + COS(@lat1)*COS(@lat2)*POWER(SIN(@delta_lon/2), 2),
                        @c := 2*ATAN2(SQRT(@a), SQRT(1-@a)),
                        6371 * @c    
                    ";
                    $query = "
                        SELECT DISTINCT 
                            *
                        FROM
                            (
                            SELECT
                                Resource.id,
                                Resource.name,
                                Resource.owner_username,
                                Resource.cost,
                                Resource.status,
                                Resource.next_available_date,
                                $distance_sql AS distance
                            FROM
                                ($base_query) AS Resource
                                LEFT JOIN Capability
                                ON Resource.id = Capability.Resource_id
                                LEFT JOIN Resource_AdditionalESF
                                ON Resource.id = Resource_AdditionalESF.Resource_id
                            ) Base    
                        WHERE
                            distance <= $distance
                        ORDER BY
                            distance ASC,  
                            next_available_date ASC,
                            name ASC
                    ";
                } else {
                    $query = $base_query;
                }

                $result = mysqli_query($connect, $query);
                if (!$result) {
                    print "$query<BR>";
                    print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                    exit();
                }

                echo "<form method='post' action='search_result.php'>";

                while ($row = mysqli_fetch_array($result)) {
                    print "<tr>";
                    print "<td>{$row['id']}</td>";
                    print "<td>{$row['name']}</td>";
                    $owner = $row['owner_username'];
                    $query_owner_type = "SELECT type FROM User Where username='$owner'";
                    $result_owner_type = mysqli_query($connect, $query_owner_type);
                    $type = mysqli_fetch_array($result_owner_type)['type'];
                    if ($type=='Individual') {
                        $query_owner_name = "SELECT firstname, lastname FROM Individual WHERE username='$owner'";
                        $result_owner_name = mysqli_query($connect, $query_owner_name);
                        $name_row = mysqli_fetch_array($result_owner_name);
                        $name = $name_row['firstname']." ".$name_row['lastname'];
                    } elseif ($type == 'Company') {
                        $query_owner_name = "SELECT name from Company WHERE username='$owner'";
                        $result_owner_name = mysqli_query($connect, $query_owner_name);
                        $name = mysqli_fetch_array($result_owner_name)['name'];
                    } elseif ($type == 'Government_Agency') {
                        $query_owner_name = "SELECT name from Government_Agency WHERE username='$owner'";
                        $result_owner_name = mysqli_query($connect, $query_owner_name);
                        $name = mysqli_fetch_array($result_owner_name)['name'];
                    } else {
                        $query_owner_name = "SELECT name from Municipality WHERE username='$owner'";
                        $result_owner_name = mysqli_query($connect, $query_owner_name);
                        $name = mysqli_fetch_array($result_owner_name)['name'];
                    }

                    $id = $row['id'];
                    $status = $row['status'];
                    $next_available_date = $row['next_available_date'];

                    print "<td>{$name}</td>";
                    print "<td>{$row['cost']}</td>";
                    print "<td>{$status}</td>";
                    if ($status == "Available") {
                        print "<td>Now</td>";
                    } else {
                        print "<td>{$next_available_date}</td>";
                    }

                    if($incident_ID != -1) {
                        print "<td>{$row['distance']}</td>";

                        print "<td>";
                        if ($status != 'In Repair') {
                            if ($owner == $username) {
                                print "<input type='submit' name='repair[$id,$status,$next_available_date]' value='Repair'>";
                                if ($status == 'Available') {
                                    print "<input type='submit' name='deploy[$id]' value='Deploy'>";
                                }
                            } else {
                                $query_requsted = "
                                    select
                                        *
                                    from
                                        Request
                                    where
                                        sender_username = '$username',
                                        AND incident_id = $incident_ID,
                                        AND requesting_resource_id = $id
                                        AND status in ('Pending', 'Accepted')                                    
                                ";
                                $result_requested = mysqli_query($connect, $query_requsted);
                                if (!$result_requested) {
                                    print "<input type='submit' name='request[$id]' value='Request'>";
                                }
                            }
                        }

                        print "</td>";
                    }
                    else {
                        print "<td></td>";
                        print "<td></td>";
                    }
                    print "</tr>";

                }

                echo "</form>";
            ?>
        </table>
        <form method="post" action="search_result.php">
            <input type="submit" name="close" value="Close" />
        </form>
    </div>
</body>
</html>
