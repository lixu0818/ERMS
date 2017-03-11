<?php
/* connect to database */
$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");
if (!$connect) {
    die("Failed to connect to database");
}
session_start();
$username = $_SESSION['username'];
$user_name = $_SESSION['user_name'];
$resource_id = $_SESSION['update_resource_id'];
$resource_name = $_SESSION['update_resource_name'];

//Show drop-down list of ESFs
$query1 = "SELECT * FROM ESF";
$esfs = mysqli_query($connect, $query1);
$esf_options = "";
while ($esf = mysqli_fetch_array($esfs)) {
    $esf_options .= "<option value=$esf[0]>(#$esf[0]) $esf[1]</option>";
}

//Show scroll list of costDenominators
$query2 = "SELECT * FROM Cost_Denominator";
$costDenominators = mysqli_query($connect, $query2);
$cost_options = "";
while ($cost = mysqli_fetch_array($costDenominators)) {
    $cost_options .= "<option value=$cost[0]>$cost[0]</option>";
}

//Onclick methods for buttons
if (isset($_POST['cancel'])) {
    header('Location: profile.php');
    exit();
}

$errorMsg = "";
if(isset($_POST['submit'])) {
    if (empty($_POST['esf']) and empty($_POST['lon']) and empty($_POST['lat']) and empty($_POST['costDenominator'])
            and empty($_POST['capabilities']) and empty($_POST['model']) and empty($_POST['esfs'])) {
        $errorMsg = "<div class='text-center' style='color:red'><BR>No attributes changed.</div>";
    }
    else {
        $res_sql = "select * from Resource where id =  $resource_id";
        $res_data = mysqli_query($connect, $res_sql);
        $res_row = mysqli_fetch_assoc($res_data);
        $primary_ESF_id = $res_row['primary_ESF_id'];
        $model = $res_row['model'];
        $lat = $res_row['lat'];
        $lon = $res_row['lon'];
        $cost = $res_row['cost_dollar_amount'];
        $costDenominator = $res_row['cost_denominator'];

        if (!empty($_POST['esf'])) {
            $primary_ESF_id = (int)$_POST['esf'];
        }
        if (!empty($_POST['model'])) {
            $model = mysqli_real_escape_string($connect, $_POST['model']);
        }
        if (!empty($_POST['lat'])) {
            $lat = (float)$_POST['lat'];
        }
        if (!empty($_POST['lon'])) {
            $lon = (float)$_POST['lon'];
        }
        if (!empty($_POST['cost'])) {
            $cost = (float)$_POST['cost'];
        }
        if (!empty($_POST['costDenominator'])) {
            $costDenominator = mysqli_real_escape_string($connect, $_POST['costDenominator']);
        }

        $additional_ESF_ids = array();
        if (!empty($_POST['esfs'])){
            $additional_ESF_ids =  $_POST['esfs'];
        }
        if (!empty($_POST['capabilities'])){
        $capabilities_text_before_parsing=mysqli_real_escape_string($connect, $_POST['capabilities']);
        $capabilities = explode(",", $capabilities_text_before_parsing);
            $capabilities = str_replace(' ', '', $capabilities);
            $capabilities =   array_unique($capabilities);
        }

        $query = "       
            Update Resource
            SET primary_ESF_id = $primary_ESF_id,
            model = '$model',        
            lat = $lat,        
            lon = $lon,
            cost_dollar_amount=$cost,
            cost_denominator='$costDenominator'        
            WHERE Resource.id = $resource_id;
        ";

        $result = mysqli_query($connect, $query);
        if (!$result) {
            echo "Error: " . $query . "<br>" . mysqli_error($connect);
        }
        else {

            echo "<BR> Resource updated successfully. Resource ID is: " . $resource_id;

            $delete_sql_a = "
                        DELETE FROM Resource_AdditionalESF
                        WHERE Resource_AdditionalESF.resource_id = $resource_id
                    ";

            mysqli_query($connect, $delete_sql_a);

            //insert additional ESFs
            foreach ($additional_ESF_ids as $additional_ESF_id){
                $insert_additional_ESF_sql = "
                    INSERT INTO Resource_AdditionalESF
                        (
                            resource_id,
                            ESF_id
                        )
                    VALUES
                        (
                            $resource_id,
                            $additional_ESF_id
                        )        
                  ";
                if (mysqli_query($connect, $insert_additional_ESF_sql)) {
                    echo "<BR>Additional ESF updated. Last updated ESF id is: " . $additional_ESF_id;
                } else {
                    echo "Error: " . $insert_additional_ESF_sql . "<br>" . mysqli_error($connect);
                }
            }

            //insert capabilities
            if (!empty($_POST['capabilities'])){
                $delete_sql_c = "
                        DELETE FROM Capability
                        WHERE Capability.resource_id = $resource_id
                    ";

                mysqli_query($connect, $delete_sql_c);

            foreach ($capabilities as $c) {
                $insert_capability_sql = "
                INSERT INTO Capability
                    (
                        resource_id,
                        capability
                    )
                VALUES
                    (
                        $resource_id,
                        '$c'
                    )            
                ";
                if (mysqli_query($connect, $insert_capability_sql)) {
                    echo "<BR>Capability inserted. Last inserted Capability is: " . $c;
                } else {
                    echo "Error: " . $insert_capability_sql . "<br>" . mysqli_error($connect);
                }
            }}
            header('Refresh:3; url=profile.php');
        }

        exit();
    }
}?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update Resource Page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
        <meta charset="utf-8">
    </head>

    <body>
        <div id="main_container">
            <h2 class="text-center"><strong>Update Resource Info</strong></h2>
            <hr>
            <form action="update_resource_2.php" method="post">
                <div class=" text-center">
                    <label>Resource ID: <?php echo $resource_id; ?>  </label>
                </div>
                <?php echo "<p class=\"text-center\"> Owner: $user_name </p>";?>
                <div class=" text-center">
                    <?php echo "<p class=\"text-center\"> Resource Name: $resource_name </p>";?>
                </div>
                <div class=" text-center">
                    <label for="esf">Primary ESF:</label>
                    <select name="esf">
                        <?php echo $esf_options; ?>
                    </select>
                    <br />
                </div>

                <div class=" text-center">
                    <label for="esfs">Additional ESFs:</label>
                    <select multiple="multiple" name="esfs[]">
                        <?php echo $esf_options; ?>
                    </select>
                </div>

                <div class=" text-center">
                    <label>Model</label>
                    <input type="text" name="model" />
                </div>

                <div class=" text-center">
                    <label>Capabilities (for multiple capabilities, separate with comma)</label>
                    <input type="text" name="capabilities" />
                </div>

                <div class=" text-center">
                    <label>Home Location </label>
                    <br>
                    <label>Lat </label>
                    <input type="number" step = "0.001" max = "90" min = "-90" name="lat" />
                    <label>Lon </label>
                    <input type="number" step = "0.001" max = "180" min = "-180" name="lon"  />
                </div>

                <div class=" text-center">
                    <label>Cost $</label>
                    <input type="number" name="cost"/>
                    <label for="costDenominator"> per </label>
                    <select name="costDenominator" multiple="multiple">
                        <?php echo $cost_options; ?>
                    </select>
                    <br />
                </div>

                <div class="text-center">
                    <input type="submit" name="submit" value="Update">
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

</html>
