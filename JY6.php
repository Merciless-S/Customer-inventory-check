<html>
<head><title>Another?</title>
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
    #no{
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
<h2>Application update Success. Would you like to update another application?<h2>
<form action="" method="post" class="mb-3">
</select>
<input type="submit" name="yes" value="yes">&emsp;&emsp;&emsp;&emsp;&emsp;
<input type="submit" id = "no" name="no" value="I have finished" />
</form>
<?php
if(isset($_POST['no'])){
    header("location: JY7.php");
}
if(isset($_POST['yes'])){
    header("location: JY5.php");
}
exit();
?>
</body>