<html>
<head><title>More hardware info</title>

</head>
<body>
<h2>Please enter the following hardware information</h2>
<?php
session_start();
$cusID = $_SESSION['cusID'];
$machineID = $_SESSION['machineID'];
// Create connection
$conn = new mysqli("localhost:3306", "root", "mysql", "covid");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$os = $sup = $web = $java = $php = $osErr = $supErr = $pur = $purErr = "";
//this function add quotes to string. If the string is empty, change it to null;
function convertString($s1){
    $s = trim(stripslashes(htmlspecialchars($_POST[$s1])));
    if($s == ""){
        $s = "NULL";
    }else{
        $s = '"'.$s.'"';
    }
    return $s;
}
//case where user clicked the submit button
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["os"])) {
        $osErr = "OS is required";
    } else {
        $os = convertString("os");
    }
    //process support date
    $sup = trim(stripslashes(htmlspecialchars($_POST["sup"])));
    $date = DateTime::createFromFormat('Y-m-d', $sup);
    $date_errors = DateTime::getLastErrors();
    if ($sup != "" && $date_errors['warning_count'] + $date_errors['error_count'] > 0) {
        $supErr = "Invalid date format";
    }else{
        if($sup == ""){
            $sup = "NULL";
        }else{
            $sup = 'DATE "'.$sup.'"';
        }
    }
    //process purchase date
    $pur = trim(stripslashes(htmlspecialchars($_POST["pur"])));
    $date = DateTime::createFromFormat('Y-m-d', $pur);
    $date_errors = DateTime::getLastErrors();
    if ($pur != "" && $date_errors['warning_count'] + $date_errors['error_count'] > 0) {
        $purErr = "Invalid date format";
    }else{
        if($pur == ""){
            $purErr = "Purchase date is required";
        }else{
            $pur = 'DATE "'.$pur.'"';
        }
    }
    $web = convertString("web");
    $java = convertString("java");
    $php = convertString("php");
    //If any mistake was found, change all field to empty
    if($purErr != "" || $osErr != "" || $supErr != ""){
        $os = $sup = $web = $java = $php  = $pur = "";
    }

}
?>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    OS: <input type="text" name="os" value="<?php echo $os;?>">
    <span class="error">* <?php echo $osErr;?></span>
    <br><br>
    Purchase date (format: yyyy-mm-dd): <input type="text" name="pur" value="<?php echo $pur;?>">
    <span class="error">* <?php echo $purErr;?></span>
    <br><br>
    Support contract end date (format: yyyy-mm-dd): <input type="text" name="sup" value="<?php echo $sup;?>">
     <?php echo $supErr;?></span>
    <br><br>
    Web server: <input type="text" name="web" value="<?php echo $web;?>">
    <br><br>
    Java version: <input type="text" name="java" value="<?php echo $java;?>">
    <br><br>
    PHP version: <input type="text" name="php" value="<?php echo $php;?>">
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>
<?php

    #case where user clicked submit button and no error was found
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $osErr == "" && $supErr == "" && $purErr == "") {
        //generate new system number
        $newSysNo = 1;
        $sql = "SELECT * FROM CUSENV";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_array()) {
                if($row["cusID"] == $cusID){
                    $newSysNo = max($newSysNo,(int)$row["sysNo"] + 1);
                }
            }
        }
        //insert the hardware information to database
        $sql = 'INSERT INTO CUSENV VALUES ('.$cusID.','. $newSysNo .',"'.$machineID.'",'.$pur.','.$sup.','.$os.','.$web.','.$java.','.$php.');';

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            $_SESSION['sysNo'] = $newSysNo;
            header("location: JY5.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        exit();
    }


?>

</body>