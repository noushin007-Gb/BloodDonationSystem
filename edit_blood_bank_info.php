<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: welcome_blood_bank.php");
    exit;
}
 
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$user_id = $Bpassword= $confirm_Bpassword = $Name = $Security_code = $Contact = $Email = $Location = $Storage_capacity 
=$facilities = $Verification = "";
$user_id_err = $Bpassword_err = $confirm_Bpassword_err = $Name_err = $Security_code_err = $Contact_err
 = $Email_err = $Location_err = $Storage_capacity_err 
=$facilities_err = $Verification_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate Validate new email
    if(empty(trim($_POST["Email"]))){
        $Email_err = "Please enter the E-mail.";
    } else{
        $Email = trim($_POST["Email"]);
    }

    if(empty(trim($_POST["Security_code"]))){
        $Security_code_err = "Enter the Security_code.";     
    }elseif(strlen(trim($_POST["Security_code"])) ==10){
        $Security_code = trim($_POST["Security_code"]);
    }else{
        $Security_code_err = "you must enter a valid Security_code";
    }

    if(empty(trim($_POST["Contact"]))){
        $Contact_err = "Enter the Contact number.";     
    }elseif(is_numeric(trim($_POST["Contact"])) && strlen(trim($_POST["Contact"])) ==11){
        $Contact = trim($_POST["Contact"]);
    }else{
        $Contact_err = "You must provide a valid Contact number.";
    }

    if(empty(trim($_POST["Location"]))){
        $Location_err = "Enter the Location.";     
    }else{
        $Location = trim($_POST["Location"]);
    }

    if(empty(trim($_POST["Storage_capacity"]))){
        $Storage_capacity_err = "Enter the Storage_capacity.";     
    }elseif(is_numeric(trim($_POST["Storage_capacity"]))){
        $Storage_capacity = trim($_POST["Storage_capacity"]);
    }else{
        $Storage_capacity_err = "Enter your Storage capacity.";
    }

    if(empty(trim($_POST["facilities"]))){
        $facilities_err = "Enter the facilities.";     
    }else{
        $facilities = trim($_POST["facilities"]);
    }

    $Verification= trim($_POST["Verification"]);

    
    // Check input errors before updating the database
    if((empty($Email_err) && empty($Security_code_err) && empty($Contact_err)&& empty($Location_err)&& empty($Storage_capacity_err)
    && empty($facilities_err))){
        // Prepare an update statement
        $sql = "UPDATE blood_bank_info SET Email= ?,Security_code =? ,Contact =?,Location =?,
        Storage_capacity =?,facilities=?,Verification =? WHERE user_id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssissi", $param_Email,
            $param_Security_code,$param_Contact,$param_Location,$param_Storage_capacity,
            $param_facilities,$Verification,$param_id);
            
            // Set parameters
            $param_Email = $Email;
            $param_Security_code = $Security_code;
            $param_Contact = $Contact;
            $param_Location = $Location;
            $param_Storage_capacity = $Storage_capacity;
            $param_facilities = $facilities;
            $param_id = $_SESSION["user_id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: blood_bank_login.php");
                exit();
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blood Bank Info</title>
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
        <h2>Edit Blood Bank  Info</h2>
        <p>Please fill out this form to Edit User Info.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($Email_err)) ? 'has-error' : ''; ?>">
                <label>E-Mail</label>
                <input type="email" name="Email" class="form-control" value="<?php echo $Email; ?>">
                <span class="help-block"><?php echo $Email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Security_code_err)) ? 'has-error' : ''; ?>">
                <label>Security_code</label>
                <input type="number" name="Security_code" class="form-control" value="<?php echo $Security_code; ?>">
                <span class="help-block"><?php echo $Security_code_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Contact_err)) ? 'has-error' : ''; ?>">
                <label>Contact Number</label>
                <input type="Text" name="Contact" class="form-control" value="<?php echo $Contact; ?>">
                <span class="help-block"><?php echo $Contact_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Location_err)) ? 'has-error' : ''; ?>">
                <label>Location</label>
                <input type="Text" name="Location" class="form-control" value="<?php echo $Location; ?>">
                <span class="help-block"><?php echo $Location_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Storage_capacity_err)) ? 'has-error' : ''; ?>">
                <label>Storage_capacity</label>
                <input type="Text" name="Storage_capacity" class="form-control" value="<?php echo $Storage_capacity; ?>">
                <span class="help-block"><?php echo $Storage_capacity_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($facilities_err)) ? 'has-error' : ''; ?>">
                <label>Facilities</label>
                <input type="Text" name="facilities" class="form-control" value="<?php echo $facilities; ?>">
                <span class="help-block"><?php echo $facilities_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Verification_err)) ? 'has-error' : ''; ?>">
                 <label for="Verification">Declair:</label>
                 <select id="Verification" name="Verification">
                 <option value="Not Verified">Not Verified</option>
                 <option value="Verified">Verified</option>
                 </select><br><br>                                      
            </div>  
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome_blood_bank.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>