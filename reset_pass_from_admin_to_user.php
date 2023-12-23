<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: welcome_admin.php");
    exit;
}

$mysqli = new mysqli("localhost","root","","blood_donation_system");
// Include config file
require_once "connection.php";


// Define variables and initialize with empty values
$id = $new_password = $confirm_password = "";
$id_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "GET"){
    
    $id = (urldecode($_GET['id']));
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty(trim($_POST["User_ID"]))){
        $User_ID_err = "Enter your User ID.";     
    }elseif(is_numeric(trim($_POST["User_ID"]))){
        $User_ID = trim($_POST["User_ID"]);
    }else{
        $User_ID_err = "Please enter a valid USER ID <br>
                        AS EXAMPLE 2013130";
    }
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        
        $sql = "UPDATE registered_user_info SET Password = ? WHERE User_ID = ? ";
        $stmt = $mysqli->prepare($sql);
        $stmt -> bind_param("si",$param_password, $User_ID); 
        $param_password = password_hash($new_password, PASSWORD_DEFAULT);
        if($stmt -> execute()){
            // updated successfully. Destroy the session, and redirect to login page
           header( "refresh:2;url=welcome_admin.php" ); 
           echo '<h1><center><b>"CHANGED USER PASSWORD SUCESSFULLY"</b>
           <br>
           redirecting you to home page in ...2...1 Seconds!!</center></h1>';
       }else{
             header( "refresh:2;welcome_admin.php" ); 
             echo "";
       }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font: 14px sans-serif;
            scale: 0.95;
            background-color: #F6F5FF;
        }

        .wrapper {
            width: 350px; 
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* Make the submit button red */
        .btn-primary {
            background-color: red;
            color: white;
        }
        .btn-primary:hover {
            background-color: purple; 
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password <?php echo '<br> for ';echo htmlspecialchars($id);?></h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
        <div class="form-group <?php echo (!empty($User_ID_err)) ? 'has-error' : ''; ?>">
                <label>USER ID</label>
                <input type="number" name="User_ID" class="form-control" value="<?php echo $id; ?>">
                <span class="help-block"><?php echo $id_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="user_pass_reset_request.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>