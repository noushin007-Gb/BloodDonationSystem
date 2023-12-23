<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT User_ID, Username,Name,Blood_Type,Age,Last_Donation,Location,UserType,
        E_mail,Phone,Health_Problem, Password FROM registered_user_info WHERE Username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $User_ID, $username,$Name,$Blood_Type,$Age,$Last_Donation,
                    $Location,$UserType,$E_mail,$Phone,$Health_Problem,$hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["User_ID"] = $User_ID;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["Name"] = $Name;  
                            $_SESSION["Blood_Type"] = $Blood_Type; 
                            $_SESSION["Age"] = $Age;   
                            $_SESSION["Last_Donation"] = $Last_Donation;
                            $_SESSION["Location"] = $Location;
                            $_SESSION["UserType"] = $UserType;
                            $_SESSION["E_mail"] = $E_mail;     
                            $_SESSION["Phone"] = $Phone;
                            $_SESSION["Health_Problem"] = $Health_Problem; 
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
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
  <title>User Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="form-box" id="userLoginForm">
      <h1>USER LOGIN</h1>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="userLogin">
        <div class="input-group">
          <div class="input-field" id="userUsernameInput">
            <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
            <input type="text" placeholder="Username" name="username" id="username">
          </div>
          <span class="help-block"><?php echo $username_err; ?></span>
          <div class="input-field" id="userPasswordInput">
            <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
            <input type="password" placeholder="Password" name="password" id="password">
          </div>
          <span class="help-block"><?php echo $password_err; ?></span>
          <p>Reset password <a href="pass_req_wit_uid.php" id="userResetPasswordLink">Click Here!</a></p>
          <div class="btn-field">
            <button type="button" class="btn" id="userRegisterBtn">Register</button>
            <button type="submit" class="btn" id="userLoginButton">Login</button>
          </div>
          <p>Login as <a href="admin_login.php" id="adminLoginLink">ADMIN</a></p>
          <p>Login as <a href="blood_bank_login.php" id="bloodBankLoginLink">BLOOD BANK</a></p>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('userRegisterBtn').addEventListener('click', function() {
      window.location.href = 'register.php';
    });
  </script>

</body>

</html>