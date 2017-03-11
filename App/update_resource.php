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

if (isset($_POST['update'])){
    foreach($_POST['update'] as $key => $value){
//        print "<p>Action: $value</p>";
//        print "<p>Update id: $key</p>";
        $keyArray = explode(',', $key);
        $_SESSION['update_resource_id'] = $keyArray[0];
        $_SESSION['update_resource_name'] = $keyArray[1];

    }
    header('Refresh:0; url=update_resource_2.php');
}

if (isset($_POST['delete'])){
    foreach($_POST['delete'] as $key => $value){
//        print "<p>Action: $value</p>";
//        print "<p>Delete id: $key</p>";
        $delete_id = $key;

        $delete_sql = "
                        DELETE FROM Resource
                        WHERE Resource.id = $delete_id
                    ";

        $return_result = mysqli_query($connect, $delete_sql);
        if ($return_result === true) {
//            print "<p>Selected resource deleted successfully</p>";
        } else {
//             print "<p>Error deleting record: " . mysqli_errno($connect) . "</p>";
            print "<b>Cannot delete selected resource: resource in use/repair or being requested</b>";
        }

    }
    header('Refresh:3; url=update_resource.php');
}
?>

<!DOCTYPE html>

<head xmlns="http://www.w3.org/1999/html">
    <title>Update Resource </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
</head>

<body>

<div id="container">

    <div id="header">
        <h2 class="text-left">Edit Resource</h2>
    </div>

    <div class="center_content">
        <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <td>Resource ID</td>
                                <td>Resource Name</td>
                                <td>Edit</td>

                            </tr>
                        </thead>
                        <?php
                        $query = "
                            SELECT
                                id, 
                                name
                            FROM
                                Resource           
                            WHERE
                            Resource.owner_username = '$username'
                        ";

                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            print "<p class='error'>Error: " . mysqli_error($connect) . "</p>";
                            exit();
                        }

                        echo "<form method='post' action='update_resource.php'>";
                        while ($row = mysqli_fetch_array($result)){
                            print "<tr>";
                            print "<td>{$row['id']} </td>";
                            print "<td>{$row['name']}</td>";
                            $resource_id= $row['id'];
                            $resource_name= $row['name'];
                            print "<td>
                                            <input type='submit' name='delete[$resource_id]' value='Delete'> 
                                            <input type='submit' name='update[$resource_id, $resource_name]' value='Update'>
                                   </td>";
                            print "</tr>";
                                 }


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
