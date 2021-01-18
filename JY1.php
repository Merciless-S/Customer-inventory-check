<html>
<head><title>Error</title>
</head>
<body>
<?php
//This file is used when a machine id cannot be found in database
//If customer is a new customer, roll back the database
session_start();
if($_SESSION['isNewCus'] == true) {
    $conn = new mysqli("localhost:3306", "root", "mysql", "covid");
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
// sql to delete a record

    $sql = "DELETE FROM CUSTOMER WHERE cusID = ". $_SESSION['cusID'];

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}
?>
<h1>Cannot find corresponding hardware. All changes rolled back. Program terminated</h1>
</body>