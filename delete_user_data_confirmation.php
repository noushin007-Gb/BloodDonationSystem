<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="refresh" content="4;url=welcome.php" />
  <title>Welcome</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body {
      font: 14px sans-serif;
      text-align: center;
      background-color: #F6F5FF;
    }

    .dropbtn {
      background-color: #ff0000;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown:hover .dropbtn {
      background-color: #ff0000;
    }
  </style>
</head>

<body>
  <div class="page-header">
    <h1>Hi, <b>
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
      </b>
      <b>
        <?php echo htmlspecialchars($_SESSION["User_ID"]); ?>
      </b>. Welcome to our site.
    </h1>
  </div>
  <label for="delete">Do you want to delete your profile?You won't able to undo it later:</label>
  <div class="dropdown">
    <button class="dropbtn">DELETE</button>
    <div class="dropdown-content">
      <a href="delete_user_data.php">YES</a>
      <a href="welcome.php">NO</a>
    </div>
  </div>
  <div class="center">

  </div>
</body>

</html>