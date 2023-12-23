<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome_admin.php");
  exit;
}
 
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$Name = $password = "";
$Name_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["Name"]))){
        $Name_err = "Please enter Name.";
    } else{
        $Name = trim($_POST["Name"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($Name_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT Admin_ID, Name, password FROM admin_own_info WHERE Name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Name);
            
            // Set parameters
            $param_Name = $Name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $Admin_ID, $Name, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["Admin_ID"] = $Admin_ID;
                            $_SESSION["Name"] = $Name;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome_admin.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $Name_err = "No account found with that username.";
                }
            } else{
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
  <title>Admin Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="form-box" id="adminLoginForm"> 
      <h1>ADMIN LOGIN</h1>
      <form id="adminLogin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="input-group">
          <div class="input-field" id="usernameInput"> 
            <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
            <input type="text" name="Name" id="Name" placeholder="Username">
          </div>
          <span class="help-block"><?php echo $Name_err; ?></span>
          <div class="input-field" id="passwordInput"> 
            <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
            <input type="password" name="password" id="password" placeholder="Password">
          </div>
          <span class="help-block"><?php echo $password_err; ?></span>
          <div class="btn-field" style="margin-left: 85px;">
            <button type="submit" class="btn" id="loginButton">Login</button> 
          </div>
          <p>Login as <a href="index.php" id="userLoginLink">USER</a></p>
          <p>Login as <a href="blood_bank_login.php" id="bloodBankLoginLink">BLOOD BANK</a></p> 
        </div>
      </form>
    </div>
  </div>
</body>

</html>