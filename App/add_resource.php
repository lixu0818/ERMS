<?php
/* connect to database */
$connect = mysqli_connect("localhost", "team021", "team021", "cs6400_team021");
if (!$connect) {
    die("Failed to connect to database");
}
session_start();
$username = $_SESSION['username'];
$user_name = $_SESSION['user_name'];
$resource_id = null;

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
    if (empty($_POST['resouceName']) or empty($_POST['esf']) or empty($_POST['lon'])
        or empty($_POST['lat']) or empty($_POST['cost']) or empty($_POST['costDenominator'])) {
        $errorMsg = "<div class='text-center' style='color:red'><BR>Must enter resource name, primary ESF, Lat, Lon and Cost.</div>";
    }
    else {
        $resource_name = mysqli_real_escape_string($connect, $_POST['resouceName']);
        $primary_ESF_id = (int)$_POST['esf'];
        $model = '';
        if (!empty($_POST['model'])){
            $model = mysqli_real_escape_string($connect, $_POST['model']);
        }
        $lat = (float)$_POST['lat'];
        $lon = (float)$_POST['lon'];
        $cost = (float)$_POST['cost'];
        $costDenominator = mysqli_real_escape_string($connect, $_POST['costDenominator']);
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
        INSERT INTO Resource
        (
            owner_username,
            name,
            primary_ESF_id,
            model,
            lat,            
            lon,
            cost_dollar_amount,
            cost_denominator
            )
        VALUES
        (
          '$username', '$resource_name',$primary_ESF_id,'$model', $lat, $lon, $cost, '$costDenominator'
        )
         ";

        $result = mysqli_query($connect, $query);
        if (!$result) {
            echo "Error: " . $query . "<br>" . mysqli_error($connect);
        }
        else {
            $resource_id = mysqli_insert_id($connect);
            echo "<p><b>New resource inserted successfully</b></p>";
            echo "<p>Resource ID is: $resource_id</p>";

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
                    echo "<BR>Additional ESF inserted. Last inserted ESF id is: " . $additional_ESF_id;
                } else {
                    echo "Error: " . $insert_additional_ESF_sql . "<br>" . mysqli_error($connect);
                }
            }

            //insert capabilities
            if (!empty($_POST['capabilities'])){
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
        }

        header('Refresh:3; url=profile.php');
        exit();
    }
}?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Incident Page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
        <meta charset="utf-8">
    </head>

    <body>
        <div id="main_container">
            <h2 class="text-center"><strong>New Resource Info</strong></h2>
            <hr>
            <form action="add_resource.php" method="post">
                <div class=" text-center">
                    <label>Resource ID: <?php echo $resource_id; ?>  </label>
                </div>
                <?php echo "<p class=\"text-center\"> Owner: $user_name </p>";?>
                <div class=" text-center">
                    <label>Resource Name      </label>
                    <input type="text" name="resouceName"/>
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
                    <input type="submit" name="submit" value="Save">
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
