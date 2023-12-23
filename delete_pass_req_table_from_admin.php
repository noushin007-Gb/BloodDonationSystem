<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: admin_login.php");
    exit;
} 
  $id = urldecode($_GET['id']);
  require "connection.php";
  $sql ="DELETE pass_req_wit_uid , user_pass_reset_request FROM pass_req_wit_uid  INNER JOIN user_pass_reset_request  
  WHERE pass_req_wit_uid.User_ID = user_pass_reset_request.User_ID and pass_req_wit_uid .User_ID = $id";
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
    <meta http-equiv="refresh" content="3;url=admin_login.php" />
    <title>Deleting User Records</title>
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