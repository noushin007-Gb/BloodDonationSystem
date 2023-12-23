<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$Name = $E_mail = $Age = $Phone = $Location
=$Last_Donation =$UserType = $Preferred_Date =$Health_Problem = "";
$Name_err = $E_mail_err = $Age_err = $Phone_err = $Location_err
=$Last_Donation_err =$UserType_err = $Preferred_Date_err =$Health_Problem_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new name
    if(empty(trim($_POST["Name"]))){
        $Name_err = "Enter your Name.";     
    } elseif(strlen(trim($_POST["Name"])) < 1){
        $Name_err = "Name must be characters.";
    } else{
        $Name = trim($_POST["Name"]);
    }
    
    // Validate Validate new email
    if(empty(trim($_POST["E_mail"]))){
        $E_mail_err = "Please enter your E_mail.";
    } else{
        $E_mail = trim($_POST["E_mail"]);
    }

    if(empty(trim($_POST["Age"]))){
        $Age_err = "Enter your Age.";     
    }elseif($_POST["Age"] < 18){
        $Age_err = "You Must Be At Least 18 Years Old";
    }else{
        $Age = trim($_POST["Age"]);
    }

    if(empty(trim($_POST["Phone"]))){
        $Phone_err = "Enter your Phone number.";     
    }elseif(is_numeric(trim($_POST["Phone"])) && strlen(trim($_POST["Phone"])) ==11){
        $Phone = trim($_POST["Phone"]);
    }else{
        $Phone_err = "You must provide a valid Phone number.";
    }

    if(empty(trim($_POST["Location"]))){
        $Location_err = "Enter your Location.";     
    }else{
        $Location = trim($_POST["Location"]);
    }

    if(empty(trim($_POST["Last_Donation"]))){
        $Last_Donation_err = "Enter your Last Donation.";     
    }elseif(is_numeric(trim($_POST["Last_Donation"]))){
        $Last_Donation = trim($_POST["Last_Donation"]);
    }else{
        $Last_Donation_err = "Enter your Last Donation in Days.";
    }

    if(empty(trim($_POST["UserType"]))){
        $UserType_err = "Enter your UserType.";     
    }else{
        $UserType = trim($_POST["UserType"]);
    }

    if(empty(trim($_POST["Preferred_Date"]))){
        $Preferred_Date_err = "Enter your Preferred_Date.";     
    }else{
        $Preferred_Date = trim($_POST["Preferred_Date"]);
    }

    if(empty(trim($_POST["Health_Problem"]))){
        $Health_Problem_err = "Enter your Health Problem.";     
    }else{
        $Health_Problem = trim($_POST["Health_Problem"]);
    }
    // Check input errors before updating the database
    if(empty($Name_err) && empty($E_mail_err) && empty($Age_err) && empty($Phone_err)&& empty($Location_err)&& empty($Last_Donation_err)
    && empty($UserType_err)&& empty($Preferred_Date_err)&& empty($Health_Problem_err)){
        // Prepare an update statement
        $sql = "UPDATE registered_user_info SET Name = ?,E_Mail= ?,Age =? ,Phone =?,Location =?,
        Last_Donation=?,UserType=?,Preferred_Date=?,Health_Problem=? WHERE User_ID = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssississsi", $param_Name,$param_E_mail,
            $param_Age,$param_Phone,$param_Location,$param_Last_Donation,$param_UserType,
            $param_Preferred_Date,$param_Health_Problem ,$param_id);
            
            // Set parameters
            $param_Name = $Name;
            $param_E_mail = $E_mail;
            $param_Age = $Age;
            $param_Phone = $Phone;
            $param_Location = $Location;
            $param_Last_Donation = $Last_Donation;
            $param_UserType = $UserType;
            $param_Preferred_Date = $Preferred_Date;
            $param_Health_Problem = $Health_Problem;
            $param_id = $_SESSION["User_ID"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // updated successfully. Destroy the session, and redirect to login page
                header("location: welcome.php");
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
    <title>Edit User Info</title>
    <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
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
        <h2>Edit User Info</h2>
        <p>Please fill out this form to Edit User Info.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($Name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="Text" name="Name" class="form-control" value="<?php echo $_SESSION["Name"]; ?>">
                <span class="help-block"><?php echo $Name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($E_mail_err)) ? 'has-error' : ''; ?>">
                <label>E-Mail</label>
                <input type="email" name="E_mail" class="form-control" value="<?php echo $_SESSION["E_mail"]; ?>">
                <span class="help-block"><?php echo $E_mail_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Age_err)) ? 'has-error' : ''; ?>">
                <label>Age</label>
                <input type="number" name="Age" class="form-control" value="<?php echo $_SESSION["Age"]; ?>">
                <span class="help-block"><?php echo $Age_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone</label>
                <input type="Text" name="Phone" class="form-control" value="<?php echo $_SESSION["Phone"]; ?>">
                <span class="help-block"><?php echo $Phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Location_err)) ? 'has-error' : ''; ?>">
                <label>Location</label>
                <input type="Text" name="Location" class="form-control" value="<?php echo $_SESSION["Location"]; ?>">
                <span class="help-block"><?php echo $Location_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Last_Donation_err)) ? 'has-error' : ''; ?>">
                <label>How many days from Last Donation?</label>
                <input type="Text" name="Last_Donation" class="form-control" value="<?php echo $_SESSION["Last_Donation"]; ?>">
                <span class="help-block"><?php echo $Last_Donation_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($UserType_err)) ? 'has-error' : ''; ?>">
                 <label for="UserType">Choose UserType:</label>
                 <select id="UserType" name="UserType">
                 <option value="ACCEPTOR">ACCEPTOR</option>
                 <option value="DONOR">DONOR</option>
                 </select><br><br>                                      
                <span class="help-block"><?php echo $UserType_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($Preferred_Date_err)) ? 'has-error' : ''; ?>">
            <label>
                 Preferred Date:
                 <input type="date" name="Preferred_Date" 
                  placeholder="yyyy-mm-dd" >
                 <span class="validity"></span>
            </label>   
            </div>  
            <div class="form-group <?php echo (!empty($Health_Problem_err)) ? 'has-error' : ''; ?>">
                <label>Health Problem</label>
                <input type="Text" name="Health_Problem" class="form-control" value="<?php echo $_SESSION["Health_Problem"]; ?>">
                <span class="help-block"><?php echo $Health_Problem_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>