
<html>
<head><title>application</title>
    <style>
        select {
            width: 100%;
            height: 50px;
            font-size: 100%;
            font-weight: bold;
            cursor: pointer;
            border-radius: 0;
            background-color: #1A33FF;
            border: none;
            border: 2px solid #1A33FF;
            border-radius: 4px;
            color: white;
            appearance: none;
            padding: 8px 38px 10px 18px;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: color 0.3s ease, background-color 0.3s ease, border-bottom-color 0.3s ease;
        }
        input[type=submit]{
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h2> Please fill out the application information below </h2>
<form action="" method="post" class="mb-3">
<?php
session_start();
$purErr = $pur = $sup = $supErr = "";
$cusID = $_SESSION['cusID'];

// Create connection
$conn = new mysqli("localhost:3306", "root", "mysql", "covid");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//generate application name from database
echo "<h3>Application Name:  </h3>";
echo "<select name=\"appName\">";
echo '<option value = "" disabled selected>Choose option</option>';
$sql = "SELECT DISTINCT appName FROM APP";
// output data of each row
$result = $conn->query($sql);
while($row = $result->fetch_array()) {
    echo "<option value = \"". $row["appName"] ."\">".$row["appName"] ."</option>";
}
echo "</select>";
echo "<br>";
echo "<h3>Release:  </h3>";
//generate release number from database
echo "<select name=\"Rel\">";
echo '<option value = "" disabled selected>Choose option</option>';
$sql = "SELECT DISTINCT Rel FROM APP";
// output data of each row
$result = $conn->query($sql);
while($row = $result->fetch_array()) {
    echo "<option value = \"". $row["Rel"] ."\">".$row["Rel"] ."</option>";
}
echo "</select><br><br>";
//case where user clicked submit button
if(isset($_POST['submit'])) {
    //process support date
    $sup = trim(stripslashes(htmlspecialchars($_POST["sup"])));
    $date = DateTime::createFromFormat('Y-m-d', $sup);
    $date_errors = DateTime::getLastErrors();
    if ($sup != "" && $date_errors['warning_count'] + $date_errors['error_count'] > 0) {
        $supErr = "Invalid date format";
    }
    //process purchase date
    $pur = trim(stripslashes(htmlspecialchars($_POST["pur"])));
    $date = DateTime::createFromFormat('Y-m-d', $pur);
    $date_errors = DateTime::getLastErrors();
    if ($pur != "" && $date_errors['warning_count'] + $date_errors['error_count'] > 0) {
        $purErr = "Invalid date format";
    } else {
        if ($pur == "") {
            $purErr = "Purchase date is required";
        }
    }
}
?>
    Purchase date (format: yyyy-mm-dd): <input type="text" name="pur" value="<?php echo $pur;?>">
    <span class="error">*<?php echo $purErr;?></span>
    <br><br>

    Support date (format: yyyy-mm-dd): <input type="text" name="sup" value="<?php echo $sup;?>">
    <?php echo $supErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="submit">
</form>
<?php
    //case where information is valid, then try to find the application id
    if(!empty($_POST['Rel']) && !empty($_POST['appName']) && $purErr == ""  && $supErr == "") {
        $appName = $_POST['appName'];
        $Rel = $_POST['Rel'];
        $sql = "SELECT * FROM APP";
        // output data of each row
        $result = $conn->query($sql);
        $appID = false;
        while($row = $result->fetch_array()) {
            //case where application id is found
            if($row["appName"] == $appName && $row["Rel"] == $Rel){
                $appID = $row["appID"];
                $pur1  = $pur;
                $sup1 = $sup;
                if($sup1 == ""){
                    $sup1 = "NULL";
                }else{
                    $sup1 = 'DATE "' . $sup1 . '"';
                }
                $pur1 = 'DATE "' . $pur1 . '"';
                //insert the information into database
                $sql1 = 'INSERT INTO CUSAPP VALUES ("'.$cusID.'","'. $appID .'",'.$pur1.','.$sup1.');';

                if ($conn->query($sql1) === TRUE) {
                    echo "New record created successfully";
                    $conn->close();
                    array_push($_SESSION['applications'], $appID);
                    header("location: JY6.php");
                } else {
                    //case where cannot insert.
                    echo "This application already exists in our database. Please try another one";
                }

            }
        }
        //case where application id can not be found, then go to error page
        if($appID == false){
            header("location: JY8.php");
        }
    } else {
        echo 'Please select the value.';
    }
    $conn->close();
    exit();
#}

?>
</body>
