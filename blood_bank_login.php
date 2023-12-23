<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: welcome_blood_bank.php");
  exit;
}

// Include config file
require_once "connection.php";

// Define variables and initialize with empty values
$Name = $user_id = $Bpassword = "";
$Name_err = $user_id_err = $Bpassword_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if user_id is empty
  if (empty(trim($_POST["Name"]))) {
    $Name_err = "Please enter Name.";
  } else {
    $Name = trim($_POST["Name"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["Bpassword"]))) {
    $Bpassword_err = "Please enter your password.";
  } else {
    $Bpassword = trim($_POST["Bpassword"]);
  }
  // Validate credentials
  if (empty($Name_err) && empty($Bpassword_err)) {
    // Prepare a select statement
    $sql = "SELECT user_id, Name,Bpassword FROM blood_bank_info WHERE Name = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_Name);

      // Set parameters
      $param_Name = $Name;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if Name exists, if yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $user_id, $Name, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($Bpassword, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["user_id"] = $user_id;
              $_SESSION["Name"] = $Name;
              // Redirect user to welcome page
              header("location: welcome_blood_bank.php");
            } else {
              // Display an error message if password is not valid
              $Bpassword_err = "The password you entered was not valid.";
            }
          }
        } else {
          // Display an error message if Name doesn't exist
          $Name_err = "No account found with that Name.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="form-box" id="bloodBankLoginForm">

      <h1>BLOOD BANK LOGIN</h1>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="bloodBankLogin">
        <div class="input-group">
          <div class="input-field" id="bloodBankUsernameInput">

            <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
            <input type="text" placeholder="Username" name="Name" id="Name">
          </div>
          <span class="help-block"><?php echo $Name_err; ?></span>
          <div class="input-field" id="bloodBankPasswordInput">

            <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
            <input type="password" placeholder="Password" name="Bpassword" id="Bpassword">
          </div>
          <span class="help-block"><?php echo $Bpassword_err; ?></span>
          <p>Reset password <a href="pass_req_wit_bbuid.php" id="bloodBankResetPasswordLink">Click Here!</a></p>

          <div class="btn-field">
            <button type="button" class="btn" id="registerBtn">Register</button>
            <button type="submit" class="btn" id="bloodBankLoginButton">Login</button>

          </div>
          <p>Login as <a href="admin_login.php" id="adminLoginLink">ADMIN</a></p>

          <p>Login as <a href="index.php" id="userLoginLink">USER</a></p>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('registerBtn').addEventListener('click', function () {
      window.location.href = 'register_blood_bank.php';
    });
  </script>
</body>

</html>