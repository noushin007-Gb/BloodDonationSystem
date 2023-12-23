<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: welcome.php");
    exit;
}
  require "connection.php";
  $sql = "DELETE FROM blood_request_user WHERE User_ID =($_SESSION[User_ID])";
  if ($link->query($sql) === TRUE) {
    echo "";
  } else {
    echo "Error deleting record: " . $link->error;
  }
  
  $link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="2;url=welcome.php" />
    <title>Deleting User Records</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="page-header">
        <h1><b>Record deleted successfully, You will be redirect to home page in 2...1... Seconds!</b></h1>
    </div>
    <div class="center">

    </div>
</body>
</html>