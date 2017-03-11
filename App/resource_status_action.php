<?php

$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");

if (isset($_POST['return'])) {
    foreach($_POST['return'] as $key => $value) {
        print "<p>Action: $value</p>";
        print "<p>Deploy Schedule Id: $key</p>";
        $deploy_schedule_id = $key;
        $return_sql = "
                        UPDATE 
                          Deploy_Schedule
                        SET 
                          end_date = sysdate()
                        WHERE 
                          id = $deploy_schedule_id                                        
                    ";

        $return_result = mysqli_query($connect, $return_sql);
        if ($return_result === true) {
            print "<p><b>Deploy Schedule updated successfully</b></p>";
        } else {
            print "<p>Error updating record: " . mysqli_errno($connect) . "</p>";
        }
    }
//    header('Location: resource_status.php');
    if(isset($_SERVER['HTTP_REFERER'])) {
        echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
    }
}

if (isset($_POST['cancel_request'])) {
    foreach($_POST['cancel_request'] as $key => $value) {
        print "<p>Action: $value</p>";
        print "<p>Request id: $key</p>";
        $request_id = $key;
        $cancel_sql = "
                        DELETE FROM Request
                        WHERE Request.id = $request_id                                      
                    ";

        $return_result = mysqli_query($connect, $cancel_sql);
        if ($return_result === true) {
            print "<p><b>Request $request_id cancelled</b></p>";
        } else {
            print "<p>Error updating record: " . mysqli_errno($connect) . "</p>";
        }
    }
//    header('Location: resource_status.php');
    if(isset($_SERVER['HTTP_REFERER'])) {
        echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
    }
}

if (isset($_POST['reject'])){
    foreach($_POST['reject'] as $key => $value){
        print "<p>Action: $value</p>";
        print "<p>Request id: $key</p>";
        $request_id = $key;

        $reject_sql = "
                        DELETE FROM Request
                        WHERE Request.id = $request_id
                    ";

        $return_result = mysqli_query($connect, $reject_sql);
        if ($return_result === true) {
            print "<p><b>Request $request_id rejected</b></p>";
        } else {
            print "<p>Error updating record: " . mysqli_errno($connect) . "</p>";
        }

    }
//    header('Location: resource_status.php');
    if(isset($_SERVER['HTTP_REFERER'])) {
        echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
    }
}

if (isset($_POST['deploy'])) {
    foreach($_POST['deploy'] as $key => $value) {
        print "<p>Action: $value</p>";
        $keyArray = explode(',', $key);
        print "<p>Request id: $keyArray[0]</p>";
        print "<p>Incident id: $keyArray[1]</p>";
        print "<p>Resource id: $keyArray[2]</p>";
        $request_id = $keyArray[0];
        $incident_id = $keyArray[1];
        $resource_id = $keyArray[2];

        // Check if this request conflicts with any scheduled repair
        $check_conflict_sql = "
            SELECT
                1
            FROM
                Repair_Schedule
            WHERE
                resource_id = $resource_id
                AND start_date > sysdate()
                AND start_date < (SELECT expected_return_date FROM Request WHERE id = $request_id) 
        ";
        $check_conflict_result = mysqli_query($connect, $check_conflict_sql);
        if (mysqli_num_rows($check_conflict_result) != 0) {
            print "<div style='color:red'><b>Schedule Conflict: must cancel scheduled repair before deploying the requested resource!</b></div><BR>";
        }
        else {
            $update_request_sql = "
                UPDATE Request
                SET status = 'Accepted'
                WHERE Request.id = $request_id;
            ";

            $update_request_result = mysqli_query($connect, $update_request_sql);
            if ($update_request_result === true) {
                print "<p><b>Request $request_id Accepted</b></p>";
            } else {
                print "<p>Error updating Request table: " . mysqli_errno($connect) . "</p>";
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
                        $resource_id,
                        $incident_id,
                        sysdate(),
                        (SELECT expected_return_date FROM Request WHERE id = $request_id)
                    );
            ";

            $insert_deploy_result = mysqli_query($connect, $insert_deploy_sql);
            if ($insert_deploy_result === true) {
                print "<p><b>Deploy Schedule updated successfully</b></p>";
            } else {
                print "<p>Error inserting Deploy_Schedule record: " . mysqli_errno($connect) . "</p>";
            }
        }
    }
//    header('Location: resource_status.php');
    if(isset($_SERVER['HTTP_REFERER'])) {
        echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
    }
}

if (isset($_POST['cancel_repair'])) {
    foreach($_POST['cancel_repair'] as $key => $value) {
        print "<p>Action: $value</p>";
        print "<p>Repair Schedule Id: $key</p>";
        $repair_schedule_id = $key;

        $cancel_sql = "
                        DELETE FROM Repair_Schedule
                        WHERE Repair_Schedule.id = $repair_schedule_id
                    ";

        $return_result = mysqli_query($connect, $cancel_sql);
        if ($return_result === true) {
            print "<p><b>Repair Schedule updated successfully</b></p>";
        } else {
            print "<p>Error updating record: " . mysqli_errno($connect) . "</p>";
        }
    }
//    header('Location: resource_status.php');
    if(isset($_SERVER['HTTP_REFERER'])) {
        echo "<a href=".$_SERVER['HTTP_REFERER'].">Go back</a>";
    }
}

?>