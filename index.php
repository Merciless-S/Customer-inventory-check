<html>
<head><title>User login</title>
</head>
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
<body>
<h2>Please select your name</h2><br>
<form action="" method="post" class="mb-3">
<?php
#start a session to store variable cross file
session_start();
$_SESSION['applications'] = array();
// Create connection
$conn = new mysqli("localhost:3306", "root", "mysql", "covid");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//create a connection to mysql and generate names for user to choose
$name = "";
echo "<select name=\"cusName\">";
echo '<option value = "" disabled selected>Choose option</option>';
echo '<option value = "new" style="color:red">New customer</option>';
$sql = "SELECT DISTINCT cusName FROM CUSTOMER";
// output data of each row
$result = $conn->query($sql);
while($row = $result->fetch_array()) {
    echo "<option value = \"". $row["cusName"] ."\">".$row["cusName"] ."</option>";
}
echo "</select>";
echo '<input type="submit" id = "submit" name="submit" value="submit" />';
?></form>

<?php
//If the user click the submit button, then proceed with input
if(isset($_POST['submit'])){
    $_SESSION['cusName'] = $_POST['cusName'];
    //case where customer is new customer
    if($_SESSION['cusName'] == "new"){
        $_SESSION['isNewCus'] = true;
        //generate new customer id for him
        $maxID = 0;
        $sql = "SELECT cusID FROM CUSTOMER";
        $result = $conn->query($sql);
        while($row = $result->fetch_array()) {
            $maxID = max($maxID, $row["cusID"]);
        }
        $_SESSION['cusID'] = $maxID + 1;
        header("location: JY2.php");
    }else{
        $_SESSION['isNewCus'] = false;
        //find out the exited customer id in database
        $sql = "SELECT * FROM customer";
        $result = $conn->query($sql);
        while($row = $result->fetch_array()) {
            if($row["cusName"] == $_SESSION['cusName']){
                $_SESSION['cusID'] = $row['cusID'];
                break;
            }
        }
        header("location: JY3.php");
    }
    $conn->close();
    exit();
}
?>

</body>
</html>