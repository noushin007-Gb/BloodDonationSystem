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
=$Last_Donation =$UserType =$Health_Problem = $Blood_Type = "";
$Name_err = $E_mail_err = $Age_err = $Phone_err = $Location_err
=$Last_Donation_err =$UserType_err = $Health_Problem_err = $Blood_Type_err =$User_ID_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new name
    if(empty($_SESSION["User_ID"])){
        $User_ID_err = "Please enter a User ID.";
    } else{
        // Prepare a select statement
        $sql = "SELECT User_ID FROM registered_user_info WHERE User_ID = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_User_ID);
            
            // Set parameters
            $param_User_ID = $_SESSION["User_ID"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $User_ID_err = "Good news!You are already a Donor,Your infos are stored ";
                } else{
                    $User_ID = $_SESSION["User_ID"];
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
    }
    if($UserType = 'ACCEPTOR'){
        
        // Prepare an insert statement
        $sql = "UPDATE registered_user_info SET UserType = ? WHERE User_ID = ?";

        if ($_SESSION["Last_Donation"] < 56) {
            // User is not eligible to donate
            header("refresh:3;url=welcome.php");
            echo '<h1><center><b>You are not eligible to donate blood yet.<br>Redirecting you in 3..2...1 seconds!</b></center></h1>';
            exit();
        } 
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si",$param_UserType,$param_User_ID);
            $param_UserType = 'DONOR';
            $param_User_ID = $_SESSION["User_ID"];
            if(mysqli_stmt_execute($stmt)){
                // updated successfully. Destroy the session, and redirect to login page
                if(empty($Name_err) && empty($E_mail_err) && empty($Age_err) && empty($Phone_err)&& empty($Location_err)&& 
                empty($Last_Donation_err)&& empty($UserType_err)&& empty($Health_Problem_err)){
                    // Prepare an update statement
                    $sql = "INSERT INTO donor_information_table (Blood_Type,User_ID,Name,Age,Last_Donation,
                    Location,UserType,E_mail,Phone,Health_Problem) VALUES ( ?,?,?, 
                    ?, ?,?,?, ?, ?,?)";
                    
                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sisiisssss", $param_Blood_Type, $param_User_ID,
                        $param_Name,$param_Age,$param_Last_Donation,$param_Location,$param_UserType,$param_E_mail,
                        $param_Phone,$param_Health_Problem);
                        
                        // Set parameters
                        $param_Blood_Type = $_SESSION["Blood_Type"];
                        $param_User_ID = $_SESSION["User_ID"];
                        $param_Name = $_SESSION["Name"];
                        $param_Age = $_SESSION["Age"];        
                        $param_Last_Donation = $_SESSION["Last_Donation"];
                        $param_Location = $_SESSION["Location"];
                        $param_UserType = 'DONOR';
                        $param_E_mail = $_SESSION["E_mail"];
                        $param_Phone = $_SESSION["Phone"];
                        $param_Health_Problem = $_SESSION["Health_Problem"];
             
                        mysqli_report(MYSQLI_REPORT_STRICT);
                        // Attempt to execute the prepared statement
                        if((($param_Last_Donation) < 56 )){
                            // updated successfully. Destroy the session, and redirect to login page
                            header( "refresh:3;url=welcome.php" ); 
                            echo '<h1><center><b>" You are not eligble to donate your blood yet </b> <br>
                                                   <b>redireacting you in 3..2...1 Seconds!"</b></center></h1>';
                            exit();
                            
                        }else{
                            if(mysqli_stmt_execute($stmt)){
                                 // updated successfully. Destroy the session, and redirect to login page
                                header("location: welcome.php");
                                exit();
                            }else{
                                  header( "refresh:1.5;url=welcome.php" ); 
                                  echo'<h1><center><b>"Good news!You are already a Donor,Your infos are stored "</b></center></h1>';
                                  die();
                            }
                        }   
                        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                }
            }
        }// Check input errors before updating the database
    }

    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BECOME A DONOR</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <!-- <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style> -->
        <style>
        body {
            background-color: #F6F5FF;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font: 14px sans-serif;
            scale: 0.95;
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
        <h2>BECOME A DONOR</h2>
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
                <label>How many days from Last Donation?(> 56)</label>
                <input type="Text" name="Last_Donation" class="form-control" value="<?php echo $_SESSION["Last_Donation"]; ?>">
                <span class="help-block"><?php echo $Last_Donation_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($UserType_err)) ? 'has-error' : ''; ?>">
                 <label for="UserType">UserType:</label>
                 <select id="UserType" name="UserType">
                 <option value="DONOR">DONOR</option>
                 </select><br><br>                                      
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