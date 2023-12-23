<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: blood_bank_login.php");
    exit;
}
  require "connection.php";
  $sql = "DELETE FROM blood_bank_info WHERE user_id =($_SESSION[user_id])";
  if ($link->query($sql) === TRUE) {
    echo "";
  } else {
    echo "Error deleting record: " . $link->error;
  }
  
  $link->close();
  session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="4;url=blood_bank_login.php" />
    <title>Deleting Blood Bank Records</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="page-header">
        <h1><b>Record deleted successfully, You will be redirect to login page in 3 seconds</b></h1>
    </div>
    <div class="center">

    </div>
</body>
</html>