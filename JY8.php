<html>
<head><title>Error</title>
</head>
<body>

<h1>Cannot find corresponding application. All changes rolled back. Program terminated</h1>
<?php
//This file is used when application id cannot be found. roll back all information in the database
session_start();
$conn = new mysqli("localhost:3306", "root", "mysql", "covid");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//delete all application information entered before
foreach ($_SESSION['applications'] as &$appID) {
    $sql = 'DELETE FROM CUSAPP WHERE cusID = '. $_SESSION['cusID'] .' AND appID = "'. $appID .'"';
    if ($conn->query($sql) === TRUE) {
        #echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
//if the customer entered hardware information, delete it from cusenv table
if($_SESSION['hasHardware'] == true) {

// sql to delete a record

    $sql = "DELETE FROM CUSENV WHERE cusID = ". $_SESSION['cusID'] ." AND sysNo = ". $_SESSION['sysNo'];

    if ($conn->query($sql) === TRUE) {
        #echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
//if the customer is a new customer, delete his id from customer table
if($_SESSION['isNewCus'] == true) {

// sql to delete a record

    $sql = "DELETE FROM CUSTOMER WHERE cusID = ". $_SESSION['cusID'];

    if ($conn->query($sql) === TRUE) {
        #echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

}
$conn->close();
?>
</body>