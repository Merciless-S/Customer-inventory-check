<html>
<head><title>new customer</title>
</head>
<style>
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
<?php
#db information
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

$sql = "SELECT * FROM customer";
// sql to create table
#start a session to inherit post information from index.php
session_start();
$newCusID = $_SESSION['cusID'];
echo "<h3>Since you are a new customer, please enter the following information</h3>";

$cusName = $cusNameErr = $contactName = $contactNo = $contactNameErr = $contactNoErr = "";
#After user clicked submit button, check if input is valid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #check customer name
    if (empty($_POST["cusName"])) {
        $cusNameErr = "Customer name is required";
    } else {
        $cusName = trim(stripslashes(htmlspecialchars($_POST["cusName"])));
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $contactName)) {
            $cusNameErr = "Only letters and white space allowed";
        }
        $sql = "SELECT * FROM customer";
        $result = $conn->query($sql);
        while($row = $result->fetch_array()) {
           if($row['cusName'] == $cusName){
               $cusNameErr = "This Customer name already exist in the database";
               break;
           }
        }
    }
    #check contact name
    if (empty($_POST["contactName"])) {
        $contactNameErr = "Contact name is required";
    } else {
        $contactName = trim(stripslashes(htmlspecialchars($_POST["contactName"])));
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $contactName)) {
            $contactNameErr = "Only letters and white space allowed";
        }
    }
    #check contact number
    if (empty($_POST["contactNo"])) {
        $contactNoErr = "Contact phone number is required";
    } else {
        $contactNo = trim(stripslashes(htmlspecialchars($_POST["contactNo"])));
        // check if name only contains letters and whitespace
        if (!is_numeric($contactNo)) {
            $contactNoErr = "Only digit allowed";
        }
    }
}
?>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Customer name: <input type="text" name="cusName" value="<?php echo $cusName;?>">
    <span class="error">* <?php echo $cusNameErr;?></span>
    <br><br>
    Contact name: <input type="text" name="contactName" value="<?php echo $contactName;?>">
    <span class="error">* <?php echo $contactNameErr;?></span>
    <br><br>
    Contact phone number: <input type="text" name="contactNo" value="<?php echo $contactNo;?>">
    <span class="error">* <?php echo $contactNoErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="submit">
</form>
<?php
    #If there is no problem with user input, insert the customer information into database
    if($_SERVER["REQUEST_METHOD"] == "POST" && $cusNameErr == "" &&$contactNameErr == "" && $contactNoErr == ""){
        #echo "INSERT INTO CUSTOMER VALUES (" . $newCusID. ",\"" . $cusName . "\", \"". $contactName ."\", ". $contactNo .")";
        $sql = "INSERT INTO CUSTOMER VALUES (" . $newCusID. ",\"" . $cusName . "\", \"". $contactName ."\", ". $contactNo .")";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header("location: JY3.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    exit();
?>
</body>