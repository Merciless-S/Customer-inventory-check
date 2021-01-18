<html>
<head><title>hardware info</title>

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
#skip{
    background-color: red;
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
<h2>Please select the manufacturer and model of your hardware below</h2><br>
    <form action="" method="post" class="mb-3">
<?php
session_start();
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
//generate manufacturer dropdown list from database
echo "<h3>manufacturer:  </h3>";
echo "<select name=\"manu\">";
echo '<option value = "" disabled selected>Choose option</option>';
$sql = "SELECT DISTINCT manufacturer FROM hardware";
// output data of each row
$result = $conn->query($sql);
while($row = $result->fetch_array()) {
    echo "<option value = \"". $row["manufacturer"] ."\">".$row["manufacturer"] ."</option>";
}
echo "</select>";
echo "<br><br>";
//generate model dropdown list from database
echo "<h3>model: </h3>";
echo "<select name=\"model\">";
echo '<option value = "" disabled selected>Choose option</option>';
$sql = "SELECT DISTINCT model FROM hardware";
// output data of each row
$result = $conn->query($sql);
while($row = $result->fetch_array()) {
    echo "<option value = \"". $row["model"] ."\">".$row["model"] ."</option>";
}
echo "</select><br><br>";
echo '<input type="submit" name="submit" value="submit">';

echo "&emsp;&emsp;&emsp;";
echo '<input type="submit" id = "skip" name="skip" value="skip" />';
?></form>


<?php
#If the user clicked skip button
if(isset($_POST['skip'])){
    $_SESSION['hasHardware'] = false;
    $conn->close();
    header("location: JY5.php");
}
#case where the user clicked submit button, then try to find the machine id from the database
if(isset($_POST['submit'])){
    if(!empty($_POST['manu']) && !empty($_POST['model'])) {
        $manu = $_POST['manu'];
        $model = $_POST['model'];
        $sql = "SELECT * FROM hardware";
        $result = $conn->query($sql);
        $machineID = false;
        while($row = $result->fetch_array()) {
            //case where machine id is found
            if($row["manufacturer"] == $manu && $row["model"] == $model){
                $machineID = true;
                $_SESSION['machineID'] = $row["machineID"];
                $conn->close();
                $_SESSION['hasHardware'] = true;
                header("location: JY4.php");
            }
        }
        //Case where machine id not found, then navigate to error message page
        if($machineID == false){
            echo "machine id not found";
            header("location: JY1.php");
            #header("location: JY5.php");
        }
    } else {
        echo 'Please select the value.';
    }
#}
}
exit();

?>
</body>